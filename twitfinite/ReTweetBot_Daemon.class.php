<?
/* TO DO
 *  - Do new bot check at the end of each cycle (tweet welcome message from @ReTweetBot
 *  - Update counts cache every 2 hours
 *  - Update followers every 15 minutes
 *  - Perform maintenance routines every 30 days
 */

class ReTweetBot_Daemon {
	public $debug_bots, $max_db_fails;
	private $dsn, $db, $bots, $db_check_count, $config;

	function __construct($dsn) {
		$this->dsn = $dsn;
		$this->queue = array();
		$this->db_check_count = 0;

		$this->debug_bots = array();
		$this->max_db_fails = 3;

		$this->db_connect();

		$config = $this->db->q_fetch_all("SELECT * FROM `config`");
		foreach($config as $row)
			$this->config[$row['var']] = $row['val'];
	}


	function __destruct() {
		$this->db_close();
	}


	private function db_connect() {
		$this->db =& new DB($this->dsn);

		return TRUE;
	}


	private function db_close() {
		unset($this->db);
	}


	private function log($action='', $arg1=FALSE, $arg2=FALSE, $arg3=FALSE) {
		$debug = debug_backtrace();

		$action = trim($action);

		if(strlen($action)==0 && isset($debug[1]['function']))
			$action = $debug[1]['function'];

		$insert = array();

		$insert['action'] = $action;
		if($arg1) $insert['arg1'] = $arg1;
		if($arg2) $insert['arg2'] = $arg2;
		if($arg3) $insert['arg3'] = $arg3;


		echo date('[Y-m-d H:i:s] ');


		/* Log stuff */
		$priority = LOG_INFO;
		$str = $action.'; '.$arg1.'; '.$arg2.'; '.$arg3;
		openlog('retweetbot',LOG_PID|LOG_PERROR,LOG_LOCAL7);
		syslog($priority,$str);
		closelog();

		$retval = $this->db->insert('daemon_log', $insert);

		return $retval;
	}


	public function start($debug_bot_id=FALSE) {
		if($debug_bot_id)
			$this->log('daemon started for debug_bot_id='.$debug_bot_id);
		else
			$this->log('daemon started');

		while(TRUE) {
			/* Check database every iteration */
			if($this->db_check()) {
				/* Refresh = 60 seconds */
				if($this->action_check('refresh_bot_queue', 60))
					$this->refresh_bot_queue($debug_bot_id);

				/* Update followers =  15 minutes */
				if($this->action_check('update_followers', 60*15))
					$this->update_followers();

				/* Update counts = 2 hours */
				if($this->action_check('update_counts', 2*60*60))
					$this->update_counts();

				/* Prune tweets = 1 month */
				#if($this->action_check('prune_tweets', 30*24*60*60))
				#	$this->prune_tweets();

				/* Prune counts_cache = 1 month */
				#if($this->action_check('prune_counts_cache', 30*24*60*60))
				#	$this->prune_counts_cache();

				/* Prune daemon_log = 1 month */
				#if($this->action_check('prune_daemon_log', 30*24*60*60))
				#	$this->prune_daemon_log();

				/* Get next bot to check */
				$this->check_next_bot($debug_bot_id);
				
				/* Sleep = 1 second */
				if($this->action_check('sleep', 1))
					$this->sleep(1);
			} else {
				$this->sleep(15);
			}
		}

		return TRUE;
	}


	private function action_check($action='', $interval=60) {
		if($interval<=0)
			$interval = 60;

		$action = trim($action);

		if(strlen($action)==0)
			$action = 'refresh_bot_queue';

		$query = "SELECT `id` FROM `daemon_log` WHERE `action`='".$action."' AND `ts`>DATE_SUB(NOW(), INTERVAL ".$interval." SECOND)";
		$retval = $this->db->q_fetch_all($query);

		if(count($retval)==0)
			$retval = TRUE;
		else
			$retval = FALSE;

		return $retval;
	}


	private function sleep($seconds=2) {
		if($seconds<1)
			$seconds = 5;

		sleep($seconds);

		return TRUE;
	}


	private function refresh_bot_queue($debug_bot_id=FALSE) {
		$this->bots = array();

		if($debug_bot_id)
			$debug_bot_sql = '`id`='.$debug_bot_id.' AND ';
		else
			$debug_bot_sql = '';

		$query = <<<EOQ
SELECT
	`id`,
	`twitter_screenname`,
	`last_check`,
	(SELECT MAX(`ts`) FROM `tweets` WHERE `group_id`=`groups`.`id`) AS `last_tweet`,
	(SELECT COUNT(*) FROM `tweets` WHERE `group_id`=`groups`.`id` AND `ts`>=DATE_SUB(NOW(), INTERVAL 1 MINUTE)) AS `tweets_in_last_minute`,
	(SELECT COUNT(*) FROM `tweets` WHERE `group_id`=`groups`.`id` AND `ts`>=DATE_SUB(NOW(), INTERVAL 1 WEEK)) AS `tweets_in_last_week`,
	(SELECT COUNT(*) FROM `tweets` WHERE `group_id`=`groups`.`id` AND `ts`>=DATE_SUB(NOW(), INTERVAL 1 MONTH)) AS `tweets_in_last_month`,
	(SELECT COUNT(*) FROM `tweets` WHERE `group_id`=`groups`.`id`) AS `tweets_since_prune`
FROM
	`groups`
WHERE
	{$debug_bot_sql}
	`disabled`=0 AND
	`id` NOT IN (
		SELECT `bot_id` FROM `daemon_bot_queue` WHERE `complete`=0
	) AND
	LENGTH(LTRIM(RTRIM(`oauth_token`)))>0 AND
	LENGTH(LTRIM(RTRIM(`oauth_secret`)))>0 AND
	`groups`.`disabled`=0
GROUP BY
	`id`,
	`twitter_screenname`
ORDER BY
	`tweets_in_last_minute` DESC,
	`tweets_in_last_week` DESC,
	`tweets_in_last_month` DESC,
	`last_tweet` DESC
EOQ;
		/* Get the bots not in the queue */
		$bots = $this->db->q_fetch_all($query);


		/* Loop through the bots */
		foreach($bots as $b) {
			$last_check_unix = strtotime($b['last_check']);
			$last_tweet_unix = strtotime($b['last_tweet']);
			$next_check_unix = 0;

			/* If we have no record of a last tweet, put it on hold for 5 minutes */
			if($last_tweet_unix=='' && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*5);

			/* If we have 1-5 tweets in the last minute, let's check in another 30 seconds */
			if($b['tweets_in_last_minute']>0 && $b['tweets_in_last_minute']<5 && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*0.5);

			/* If we have 5+ tweets in the last minute, let's check in another 15 seconds */
			if($b['tweets_in_last_minute']>5 && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*0.25);

			/* If we've had a tweet in the past 3.5 days, keep it on schedule */
			if($b['tweets_in_last_week']>0 && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*1);

			/* If we haven't had a tweet in the last week, hold on for 2 minutes */
			if($b['tweets_in_last_week']==0 && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*2);

			/* If we haven't had a tweet in the last month, hold on for 3 minutes */
			if($b['tweets_in_last_month']==0 && $next_check_unix>0)
				$next_check_unix = $last_check_unix+(60*3);

			/* If it's greater than a month, but since a prune, hold on for 4 minutes */
			if($next_check_unix==0)
				$next_check_unix = $last_check_unix+(60*4);

			/* Now, push the update to the bot queue */
			$this->queue_bot($b['id'], $next_check_unix);
		}

		$this->log();

		return TRUE;
	}


	private function queue_bot($id, $next_check_unix=0) {
		$retval = FALSE;

		if($next_check_unix<time())
			$next_check_unix = time()+60;

		$insert = array(
			'bot_id' => $id,
			'queue_ts' => date('Y-m-d H:i:s', $next_check_unix)
		);

		$retval = $this->db->insert('daemon_bot_queue', $insert);

		$this->log('', $retval, 'bot_id: '.$id, 'next check: '.date('Y-m-d H:i:s',$next_check_unix).' ('.$next_check_unix.')');

		return $retval;
	}


	private function check_next_bot($debug_bot_id=FALSE) {
		$retval = FALSE;

		if($debug_bot_id)
			$debug_bot_sql = '`groups`.`id`='.$debug_bot_id.' AND ';
		else
			$debug_bot_sql = '';
		
		$query = <<<EOQ
SELECT
	`daemon_bot_queue`.`id`,
	`daemon_bot_queue`.`bot_id`,
	`daemon_bot_queue`.`queue_ts`,
	`groups`.`oauth_token`,
	`groups`.`oauth_secret`
FROM
	`daemon_bot_queue`
		INNER JOIN `groups` ON
			`groups`.`id`=`daemon_bot_queue`.`bot_id`
WHERE
	{$debug_bot_sql}
	`daemon_bot_queue`.`complete`=0 AND
	`groups`.`disabled`=0
ORDER BY
	`daemon_bot_queue`.`queue_ts` ASC
LIMIT 1
EOQ;
		$next_bot = $this->db->q_fetch_all($query, 0);

		if(count($next_bot)>0) {
			$this->log('', $next_bot['bot_id'], 'queue_id: '.$next_bot['id'], 'queue_ts: '.$next_bot['queue_ts']);

			$bot =& new ReTweetBot($next_bot['oauth_token'], $next_bot['oauth_secret']);
			$bot->check_all();
			unset($bot);

			$query = "UPDATE `daemon_bot_queue` SET `complete`=1 WHERE `id`=".$next_bot['id'];
			$this->db->q($query);
			
			$retval = TRUE;
		} else {
			$retval = FALSE;
		}

		return $retval;
	}


	private function db_check() {
		if(!$this->db->ping()) {
			$this->log('', 'failed count: '.($this->db_check_count+1), date('Y-m-d H:i:s'));

			$this->db_close();

			$this->db_connect();

			$this->db_check_count++;

			if($this->db_check_count>=$this->max_db_fails) {
				$this->db_check_count = 0;
				return FALSE;
			} else {
				return $this->db_check();
			}
		} else {
			$this->db_check_count = 0;
			return TRUE;
		}
	}


	private function prune_tweets() {
		$this->log();
		return TRUE;

		$maint =& new ReTweetBot_Maintenance($this->dsn);
		$maint->prune_tweets();
		unset($maint);
	}


	private function prune_counts_cache() {
		$this->log();

		$maint =& new ReTweetBot_Maintenance($this->dsn);
		$maint->prune_counts_cache();
		unset($maint);
	}


	private function prune_daemon_log() {
		$this->log();

		$maint =& new ReTweetBot_Maintenance($this->dsn);
		$maint->prune_daemon_log();
		unset($maint);
	}
	
	
	private function get_bots() {
		$query = "SELECT `id` FROM `groups` WHERE `disabled`=0";
		
		return $this->db->q_fetch_all($query);
	}


	private function update_followers() {
		$this->log();
		$this->bots = $this->get_bots();
		return TRUE;

		foreach($this->bots as $b) {
			$periodic =& new ReTweetBot_Periodic($b['id']);
			$periodic->update_followers();
			unset($periodic);
		}
	}


	private function update_counts() {
		$this->log();
		$this->bots = $this->get_bots();
		return TRUE;

		foreach($this->bots as $b) {
			$periodic =& new ReTweetBot_Periodic($b['id']);
			$periodic->update_counts();
			unset($periodic);
		}
	}
}
?>
