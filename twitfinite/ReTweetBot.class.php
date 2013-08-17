<?
class ReTweetBot {
	public $opt, $t, $counts, $id;
	protected $oauth_token, $oaut_secret, $db;
	private $config;

	function __construct($oauth_token, $oauth_secret) {
		$this->oauth_token = $oauth_token;
		$this->oauth_secret = $oauth_secret;

		$this->db_connect();
		$this->opt = $this->get_record();
		$this->counts = $this->get_counts();

		$this->id = $this->opt['id'];

		$config = $this->db->q_fetch_all("SELECT * FROM `config`");
		foreach($config as $row)
			$this->config[$row['var']] = $row['val'];

		$this->t = new Twitter($this->config['CONSUMER_KEY'], $this->config['CONSUMER_SECRET'], $this->opt['oauth_token'], $this->opt['oauth_secret']);
	}


	function __destruct() {

	}


	/* Enable debugging */
	public function set_debug($debug=TRUE) {
		$this->t->debug = $debug;
		$this->db->debug = $debug;
	}


	/* Check and process direct messages and mentions */
	public function check_all() {
		$tweets = array();
		$dms = array();
		$mentions = array();
		$friends = array();
		$followers = array();


		/* Get mentions and direct messages */
		if($this->opt['use_replies']==1) $mentions = $this->get_mentions($this->get_max_mention());

		// We always need to get DMs (to check for console commands)
		$max_dm = $this->get_max_dm();
		$dms = $this->get_dms($max_dm);

		foreach($dms as $dm_k => $dm_v)
			if(bccomp($max_dm, $dm_v['id_str'])<1)
				unset($dms[$dm_k]);
		
		/* Get tweets by friends and followers */
		if($this->opt['retweet_friends']==1) $friends = $this->get_friendtweets($this->get_max_friendtweet());
		if($this->opt['retweet_followers']==1) $followers = $this->get_followertweets($this->get_max_followertweets());


		/* Check for console commands */
		foreach($dms as $dm_k => $dm_v)
			if($this->console_process_command($dm_v))
				unset($dms[$dm_k]);


		/* Combine mentions and direct messages */
		$tweets = $mentions+$friends;

		// Only combine DMs if we're supposed to
		if($this->opt['use_directmessages']==1)
			$tweets += $dms;


		/* Loop through tweets and process */
		foreach($tweets as $t)
			if(strlen($t['text'])>0) {
				if(isset($t['id_str']))
					$t['id'] = $t['id_str'];
				$this->tweet($t);
			}


		/* Update the last check time */
		$query = "UPDATE `groups` SET `last_check`=NOW() WHERE `group_id`=".$this->id;
		$this->db->q($query);


		/* Return something */
		return count($tweets);
	}


	/* Process and post tweet */
	public function tweet($status=array()) {
		$retval = TRUE;
		$err = array();
		$text = '';
		$user_sender = 'user';

		/* Set some defaults to pass to statuses_update */
		$su_in_reply_to_status_id = FALSE;
		$su_lat = FALSE;
		$su_long = FALSE;
		$su_place_id = FALSE;
		$su_display_coordinates = FALSE;


		/* If it's a DM, we should use "sender" instead of "user" */
		if($status['type']=='dm') $user_sender = 'sender';

		$this->log($this->opt['twitter_screenname'].': received new '.$status['type'].' ('.$status['id'].')');


		/* Set the update text */
		$text = $status['text'];


		/* Check if we are on the blacklist */
		if(!$this->blacklist_check($status[$user_sender]['id'], $status[$user_sender]['screen_name'])) {
			$err['blacklist'] = FALSE;
			$passed_blacklist = 0;
		} else
			$passed_blacklist = 1;


		/* Check if we have permission */
		if(!$this->permissions_check($status[$user_sender]['id'])) {
			$err['acl'] = FALSE;
			$passed_acl = 0;
		} else
			$passed_acl = 1;


		/* Check if it passes the bad word filter */
		if(!$text=$this->badword_filter($text)) {
			$err['badword'] = FALSE;
			$passed_badword = 0;
		} else
			$passed_badword = 1;


		/* Check if it passes the link filter */
		if(!$text=$this->link_filter($text)) {
			$err['linkfilter'] = FALSE;
			$passed_linkfilter = 0;
		} else
			$passed_linkfilter = 1;


		/* Check if it passes the reactivation cutoff safety net */
		if(!$this->reactivate_safety_check($status['created_at'])) {
			$err['reactivate_cutoff'] = FALSE;
			$passed_reactivate_cutoff = 0;
		} else
			$passed_reactivate_cutoff = 1;


		/* Do a double-check to make sure we're retweeting friends and it's not one of our bots */
		if($status['type']=='friend' && !$this->botloop_check($status[$user_sender]['name']))
			$err['botcheck'] = FALSE;


		/* Build our INSERT array */
		$insert = array(
			'group_id' => $this->id,
			'status_id' => $status['id'],
			'post_status_id' => 0,
			'screen_name' => $status[$user_sender]['screen_name'],
			'twitter_user_id' => $status[$user_sender]['id'],
			'tweet' => $text,
			'incoming_type' => $status['type'],
			'passed_acl' => $passed_acl,
			'passed_badword' => $passed_badword,
			'passed_blacklist' => $passed_blacklist,
			'passed_linkfilter' => $passed_linkfilter,
			'passed_reactivate_cutoff' => $passed_reactivate_cutoff
		);


		/* If geo_passthru is enabled ... */
		if($this->opt['geo_passthru']==1) {
			/* Grab the place_id */
			if(isset($status['place']['id'])) {
				$su_place_id = $status['place']['id'];

				$insert['geo_place_id'] = $su_place_id;
			}

			/* Grab the coordinates */
			if(isset($status['geo']['coordinates'][0]) && isset($status['geo']['coordinates'][1])) {
				$su_lat = $status['geo']['coordinates'][0];
				$su_long = $status['geo']['coordinates'][1];
				$su_display_coordinates = 'true';

				$insert['geo_lat'] = $su_lat;
				$insert['geo_long'] = $su_long;
				$insert['geo_display_coordinates'] = 1;
			}
		}


		/* Make sure we haven't seen this tweet before */
		$query = "SELECT COUNT(`id`) AS `count` FROM `tweets` WHERE `status_id`=".$status['id'];
		$duplicates = $this->db->q_fetch_all($query,0,'count');
		if($duplicates>0)
			return array();


		/* Log if we have any errors and return */
		if(count($err)==0) {
			/* Pre-pend the formatted username to the update */
			if($this->opt['show_names'])
				$sn = $this->set_username($status[$user_sender]['screen_name'],$status).' ';
			else
				$sn = '';
			
			/* Generate a random delimiter */
			$delim = '';
			for($i=0;$i<=rand(10,20);$i++)
				$delim .= chr(rand(32,126));

			/* Figure out where to word-wrap */
			$wordwrap = 140-strlen($sn)-strlen(' '.$this->opt['autosplit_delimiter']);

			/* Determine the number of tweets */
			$num_tweets = ceil(strlen($text)/$wordwrap);

			/* Now, if we need to do multiple tweets */
			if($num_tweets>1 && $this->opt['autosplit_enabled']==1) {
				/* Wrap the text */
				$new_text = wordwrap($text,$wordwrap,$delim);

				/* Explode into an array */
				$new_text = explode($delim,$new_text);

				/* Loop! */
				for($i=0;$i<count($new_text);$i++) {
					$custom_delim = str_replace('%x',$i+1,$this->opt['autosplit_delimiter']);
					$custom_delim = str_replace('%X',$num_tweets,$custom_delim);

					$text = $sn.$new_text[$i].' '.$custom_delim;

					/* Append hash tags if we have room */
					$text = $this->append_hashtags($text);

					/* Update the INSERT */
					$insert['tweet'] = $text;

					/* Make the post */
					$post = $this->t->statuses_update($text, $su_in_reply_to_status_id, $su_lat, $su_long, $su_place_id, $su_display_coordinates);

					/* Log and wrap it up */
					if(!isset($post['error'])) {
						$insert['post_status_id'] = $post['id_str'];
						$this->log($this->opt['twitter_screenname'].': posted update ('.$post['id_str'].')');
					} else
						$this->log($this->opt['twitter_screenname'].': did not post update, '.$post['error']);
				}
			} else {
				/* Just a single, lonely tweet */
				$text = $sn.$text;

				/* Append hash tags if we have room */
				$text = $this->append_hashtags($text);

				/* Update the INSERT */
				$insert['tweet'] = $text;

				/* Make the post */
				$post = $this->t->statuses_update($text, $su_in_reply_to_status_id, $su_lat, $su_long, $su_place_id, $su_display_coordinates);

				/* Log and wrap it up */
				if(!isset($post['error'])) {
					$insert['post_status_id'] = $post['id_str'];
					$this->log($this->opt['twitter_screenname'].': posted update ('.$post['id_str'].')');
				} else
					$this->log($this->opt['twitter_screenname'].': did not post update, '.$post['error']);
			}
		} else {
			$err_msg = array();

			foreach($err as $e_k => $e_v) {
				$insert['passed_'.$e_k] = tf10($e_v);

				$err_msg[] = 'failed '.$e_k;
			}

			$insert['tweet'] = $text;

			$this->log($this->opt['twitter_screenname'].': '.implode(', ', $err_msg));
		}


		/* Post the update to the database */
		$tweet_id = $this->db->insert('tweets', $insert);


		/* Update the last tweet timestamp in the database */
		$query = "UPDATE `groups` SET `last_tweet`=NOW() WHERE `group_id`=".$this->id;
		$this->db->q($query);


		/* Post-process words */
		#if(count($err)==0)
		#	$this->bank_words($status['text'], $tweet_id);


		/* Post-process hash tags */
		#if(count($err)==0)
		#	$this->bank_hashtags($text, $tweet_id);


		return TRUE;
	}


	/* Set username */
	public function set_username($username='',$status=array()) {
		$retval = TRUE;

		if($this->opt['enable_anonymous']==1) {
			if(isset($status['user']['id']))
				$user_id = $status['user']['id'];
			elseif(isset($status['sender']['id']))
				$user_id = $status['sender']['id'];

			if(isset($user_id)) {
				/* Look up the anonymous "combo id" */
				$query = "SELECT `combo_id` FROM `users_anon` WHERE `twitter_user_id`=".$user_id." AND `group_id`=".$this->id;
				$anon = $this->db->q_fetch_all($query);

				if(count($anon)>0) {
					/* They exist, use the existing name */
					$combo_id = $anon[0]['combo_id'];
				} else {
					/* They don't exist, insert a new record */
					$insert = array(
						'twitter_user_id' => $user_id,
						'group_id' => $group_id
					);
					$this->db->insert('users_anon',$insert);

					/* Get the max combo id and add 1 to it */
					$query = "SELECT COALESCE(MAX(`combo_id`),0) AS `combo_id` FROM `users_anon` WHERE `group_id`=".$this->id;
					$combo_id = $this->db->q_result($query,'combo_id',0);
					$combo_id += 1;

					/* Update with the new combo_id */
					$query = 'UPDATE `users_anon` SET `combo_id`='.$combo_id.' WHERE `twitter_user_id`='.$user_id.' AND `group_id`='.$this->id;
					$this->db->q($query);
				}

				/* Now, set the username according to anonymous_username_format */
				$retval = sprintf($this->opt['anonymous_username_format'],$this->opt['anonymous_username_prepend'],$combo_id);
			} else
				$retval = $this->opt['anonymous_username_format'].'????:';
		} else
			$retval = str_replace('%%username%%', $username, $this->opt['username_format']);

		return $retval;
	}


	/* Append hash tags to tweet */
	public function append_hashtags($text='') {
		$hashtags = $this->get_hashtags();

		foreach($hashtags as $ht)
			if(strlen($text.' '.$ht)<=140)
				$text .= ' '.$ht;

		return $text;
	}


	/* Log stuff */
	protected function log($str,$priority='n') {
		echo date('[Y-m-d H:i:s] ');

		if($priority=='n') {
			$priority = LOG_NOTICE;
		} else {
			$priority = LOG_INFO;
		}

		openlog('retweetbot',LOG_PID|LOG_PERROR,LOG_LOCAL7);
		syslog($priority,$str);
		closelog();
	}


	/* Connect to the database */
	private function db_connect() {
		global $retweetbot_dsn;
		$this->db = new DB($retweetbot_dsn);
	}


	/* Retrieve record for bot */
	private function get_record() {
		$query = "SELECT * FROM `groups` WHERE `oauth_token`='".$this->oauth_token."' AND `oauth_secret`='".$this->oauth_secret."'";
		$retval = $this->db->q_fetch_all($query,0);

		return $retval;
	}


	/* Get the counts */
	private function get_counts() {
		$query = <<<EOQ
SELECT
	COALESCE(`counts_cache`.`statuses_count`,0) AS `statuses_count`,
	COALESCE(`counts_cache`.`friends_count`,0) AS `friends_count`,
	COALESCE(`counts_cache`.`followers_count`,0) AS `followers_count`,
	COALESCE(`counts_cache`.`ts`,NOW()) AS `ts`
FROM
	`groups`
		LEFT OUTER JOIN `counts_cache` ON
			`counts_cache`.`group_id`=`groups`.`id`
		INNER JOIN (SELECT MAX(`id`) AS `id` FROM `counts_cache` GROUP BY `group_id`) AS `cc2` ON
			`cc2`.`id`=`counts_cache`.`id`
WHERE
	`groups`.`id`={$this->id}
EOQ;

		return $this->db->q_fetch_all($query, 0);
	}


	/* Get the max direct message status from tweets and console_commands */
	public function get_max_dm() {
		$retval = 0;

		$query = "SELECT COALESCE(`status_id`,'0') AS `status_id` FROM `tweets` WHERE `group_id`=".$this->id." AND `incoming_type`='dm' ORDER BY `ts` DESC LIMIT 1";
		$tweet_dm = $this->db->q_result($query, 'status_id', 0);

		$query = "SELECT `status_id` FROM `console_commands` WHERE `group_id`=".$this->id." ORDER BY `ts` DESC LIMIT 1";
		$console_dm = $this->db->q_result($query, 'status_id', 0);

		if($tweet_dm>$console_dm)
			$retval = $tweet_dm;
		else
			$retval = $console_dm;

		return $retval;
	}


	/* Get the max mention status from tweets */
	public function get_max_mention() {
		$query = "SELECT COALESCE(`status_id`,'0') AS `status_id` FROM `tweets` WHERE `group_id`=".$this->id." AND `incoming_type`='reply' ORDER BY `ts` DESC LIMIT 1";

		$retval = $this->db->q_result($query, 'status_id', 0);

		return $retval;
	}


	/* Get the max friend tweet status from tweets */
	public function get_max_friendtweet() {
		$query = "SELECT COALESCE(`status_id`,'0') AS `status_id` FROM `tweets` WHERE `group_id`=".$this->id." AND `incoming_type`='friend' ORDER BY `ts` DESC LIMIT 1";

		$retval = $this->db->q_result($query, 'status_id', 0);

		return $retval;
	}


	/* Get the max follower tweet status from tweets */
	public function get_max_followertweet() {
		$query = "SELECT COALESCE(`status_id`,'0') AS `status_id` FROM `tweets` WHERE `group_id`=".$this->id." AND `incoming_type`='follower' ORDER BY `ts` DESC LIMIT 1";

		$retval = $this->db->q_result($query, 'status_id', 0);

		return $retval;
	}


	/* Get direct messages */
	public function get_dms($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$retval = array();

		/* Log it */
		$this->log($this->opt['twitter_screenname'].' ('.$this->opt['id'].'): checking direct messages');

		$dms = $this->t->direct_messages($since_id, $max_id, $count, $page);

		if(isset($dms['error']))
			return array();
		else
			foreach($dms as $d)
				$retval[strtotime($d['created_at'])] = $d+array('type'=>'dm');

		ksort($retval);

		return $retval;
	}


	/* Get mentions */
	public function get_mentions($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$retval = array();

		/* Log it */
		$this->log($this->opt['twitter_screenname'].' ('.$this->opt['id'].'): checking mentions');

		$mentions = $this->t->statuses_mentions($since_id, $max_id, $count, $page);

		if(isset($mentions['error']))
			return array();
		else
			foreach($mentions as $m)
				if(stripos($m['text'], '@'.$this->opt['twitter_screenname'])==0) {
					$m['text'] = trim(substr($m['text'], strlen('@'.$this->opt['twitter_screenname'])));
					$retval[strtotime($m['created_at'])] = $m+array('type'=>'reply');
				}

		ksort($retval);

		return $retval;
	}


	/* Get friend tweets */
	public function get_friendtweets($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$retval = array();

		/* Log it */
		$this->log($this->opt['twitter_screenname'].': checking friend tweets');

		$friendtweets = $this->t->statuses_friends_timeline($since_id, $max_id, $count, $page);

		foreach($friendtweets as $f) {
			$retval[strtotime($f['created_at'])] = $f+array('type'=>'friend');
		}

		ksort($retval);

		return $retval;
	}


	/* Get follower tweets */
	public function get_followertweets($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		return array();
	}


	/* Check if a user is on the blacklist */
	public function blacklist_check($user_id=-1, $screen_name='') {
		$count = 0;
		
		// Check on user_id
		$query = "SELECT COUNT(`id`) AS `count` FROM `group_blacklist` WHERE `group_id`=".$this->id." AND `twitter_user_id`=".$user_id." LIMIT 1";
		$count += $this->db->q_result($query, 'count', 0);
		
		
		// Check on screen name
		$query = "SELECT COUNT(`id`) AS `count` FROM `group_blacklist` WHERE `group_id`=".$this->id." AND `twitter_screenname`='".$screen_name."' LIMIT 1";
		$count += $this->db->q_result($query, 'count', 0);

		if($count>0)
			return FALSE;
		else
			return TRUE;
	}


	/* Perform any bad word filtering */
	public function badword_filter($status='') {
		$status = trim($status);
		$retval = $status;
		$words = explode(' ', $status);


		if($this->opt['badwords_filter']<>'') {
			$badwords = $this->get_badwords();

			foreach($words as $w_k => $w_v)
				if(in_array(strtolower(trim($w_v)), $badwords))
					$words[$w_k] = $w_v[0].str_repeat('*',strlen($w_v)-2).$w_v[strlen($w_v)-1];
		}

		switch($this->opt['badwords_filter']) {
			case 'c':
				$retval = trim(implode(' ',$words));
				break;
			case 'b':
				if(strcmp($status,trim(implode(' ',$words)))!=0)
					$retval = FALSE;
				break;
		}

		return $retval;
	}


	/* Get the list of bad words from the database */
	private function get_badwords() {
		$retval = array();
		$query = "SELECT `badword` FROM `badwords`";

		if($this->opt['use_default_badwords']==1)
			$query .= " UNION ALL SELECT `badword` FROM `group_badwords` WHERE `group_id`=".$this->id;

		$query .= " ORDER BY `badword` ASC";

		$retval = $this->db->q_fetch_all($query, FALSE, 'badword');

		foreach($retval as $r_k => $r_v)
			$retval[$r_k] = trim(strtolower($r_v));

		return $retval;
	}


	/* Perform any link filtering */
	public function link_filter($status='') {
		$retval = $status;

		$regex = '(((file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp)://)|(www\.))+(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(/[a-zA-Z0-9\&amp;%_\./-~-]*)?';

		eregi($regex,$status,$matches);

		if($matches) {
			switch($this->opt['link_filter']) {
				case 'b':  # Block entire post
					$retval = FALSE;
					break;
				case 'd':  # Delete link
					$retval = eregi_replace($regex,'[blocked]',$status);
					break;
			}
		}

		return $retval;
	}


	/* Make sure we have permissions to do anything that requires permissions */
	public function permissions_check($user_id=0) {
		$retval = FALSE;

		switch($this->opt['retweet_restrictions']) {
			case 'a':
				$retval = $this->permissions_check_admins($user_id);
				break;
			case 'i':
				$retval = $this->permissions_check_inclusions($user_id);
				break;
			default:
				$retval = TRUE;
		}

		return $retval;
	}


	/* Admin-specific permissions check */
	public function permissions_check_admins($user_id=0) {
		$retval = FALSE;

		$query = "SELECT COUNT(`id`) AS `count` FROM `group_admins` WHERE `group_id`=".$this->id." AND `twitter_user_id`='".$user_id."'";
		if($this->db->q_result($query, 'count', 0)>0)
			$retval = TRUE;
		else
			$retval = FALSE;

		return $retval;
	}


	/* Inclusions-specific permissions check */
	public function permissions_check_inclusions($user_id=0) {
		$retval = $this->permissions_check_admins($user_id);

		if(!$retval) {
			$query = "SELECT COUNT(`id`) AS `count` FROM `group_inclusions` WHERE `group_id`=".$this->id." AND `twitter_user_id`='".$user_id."'";
			if($this->db->q_result($query, 'count', 0)>0)
				$retval = TRUE;
			else
				$retval = FALSE;
		}

		return $retval;
	}


	/* An extra safety net against spam after re-activating */
	public function reactivate_safety_check($time='') {
		$retval = FALSE;

		/* Return early if it's disabled */
		if($this->opt['reactivate_cutoff_hours']==0)
			return TRUE;

		$reactivate_cutoff_time = time()-$this->opt['reactivate_cutoff_hours']*3600;

		if(strtotime($time)>=$reactivate_cutoff_time)
			$retval = TRUE;

		return $retval;
	}


	/* Make sure the tweet isn't from one of our bots */
	public function botloop_check($screenname='') {
		$retval = TRUE;

		$screenname = strtolower($screenname);

		$query = "SELECT LOWER(`twitter_screenname`) AS `twitter_screenname` FROM `groups`";
		$bots = $this->db->q_fetch_all($query);

		foreach($bots as $b)
			if($screenname==$b['twitter_screenname'])
				$retval = FALSE;

		return $retval;
	}


	/* Check/process a console command */
	public function console_process_command($status=array()) {
		$retval = FALSE;
		$command = FALSE;
		$args = FALSE;
		
		
		// Make sure we haven't seen this DM before
		$query = "SELECT `id` FROM `console_commands` WHERE `group_id`=".$this->id."  AND `status_id`='".$status['id']."' LIMIT 1";
		if($this->db->q_num_rows($query)>0)
			return FALSE;

		/* Return FALSE early if the user doesn't have permissions */
		if(!$this->permissions_check_admins($status['sender']['id']))
			return FALSE;

		$pattern = '/([A-Za-z0-9\_]+)\|(.+)/';
		preg_match($pattern, $status['text'], $matches);

		if(count($matches)>1) {
			$command = strtolower(trim($matches[1]));

			if(count($matches)>2) $args = trim($matches[2]);

			echo '[COMMAND] '.$command.PHP_EOL;
			echo '[ARGS] '.$args.PHP_EOL;

			switch($command) {
				case 'help':
					$retval = $this->console_command_help();
					break;
				case 'u':
					$retval = $this->console_command_u($args);
					break;
				case 'block':
					$retval = $this->console_command_block($args);
					break;
				case 'unblock':
					$retval = $this->console_command_unblock($args);
					break;
				case 'multiblock':
					$retval = $this->console_command_multiblock($args);
					break;
				case 'multiunblock':
					$retval = $this->console_command_multiunblock($args);
					break;
				case 'hash':
				case 'updatehash':
					$retval = $this->console_command_updatehash($args);
					break;
				case 'addhash':
				case 'hash+':
					$retval = $this->console_command_addhash($args);
					break;
				case 'delhash':
				case 'hash-':
					$retval = $this->console_command_delhash($args);
					break;
				case 'dma':
					$retval = $this->console_command_dma($args);
					break;
				case 'del':
					$retval = $this->console_command_del($args);
					break;
				case 'nuke':
					$retval = $this->console_command_nuke($args);
					break;
			}


			$this->console_log($status, $retval);

			if(count($retval)>0 && $this->opt['console_confirm_dm']==1)
				$this->console_confirm($status,$retval);
		}


		return $retval;
	}


	/* Log the console command */
	private function console_log($status=array(),$retval=array()) {
		$insert = array(
			'group_id' => $this->id,
			'status_id' => $status['id'],
			'twitter_screenname' => $status['sender']['screen_name'],
			'twitter_user_id' => $status['sender']['id'],
			'command' => $status['text']
		);


		$id = $this->db->insert('console_commands', $insert);


		/* Output */
		$message = trim($retval['message']);

		if($retval['success'])
			$message = '[PASS] '.$message;
		else
			$message = '[FAIL] '.$message;

		$this->log($this->opt['twitter_screenname'].': Command "'.$status['text'].'": '.$message.' ('.$id.')');


		return $id;
	}


	/* Send confirmation DM */
	private function console_confirm($status=array(), $params=array()) {
		$retval = TRUE;

		$message = trim($params['message']);

		if($params['success'])
			$message = '[PASS] '.$message;
		else
			$message = '[FAIL] '.$message;

		$text = substr('Command "'.$status['text'].'": '.$message,0,140);
		$this->t->direct_messages_new($text, $status['sender']['id']);

		return $retval;
	}


	/* Console command to update status */
	private function console_command_u($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$request = $this->t->statuses_update($args);

		if(isset($request['error'])) {
			$retval['success'] = FALSE;
			$retval['message'] = $request['error'];
		} else {
			$retval['message'] = 'http://twitter.com/'.$request['user']['screen_name'].'/status/'.$request['id'];
			$retval['id'] = $request['id'];
		}


		return $retval;
	}


	/* Console command to block a user */
	private function console_command_block($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$request = $this->t->blocks_create(FALSE, FALSE, $args);

		if(isset($request['error'])) {
			$retval['success'] = FALSE;
			$retval['message'] = $request['error'];
		} else {
			$retval['message'] = 'Successfully blocked '.$args;
		}

		return $retval;
	}


	/* Console command to unblock a user */
	private function console_command_unblock($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$request = $this->t->blocks_destroy(FALSE, FALSE, $args);

		if(isset($request['error'])) {
			$retval['success'] = FALSE;
			$retval['message'] = $request['error'];
		} else {
			$retval['message'] = 'Successfully unblocked '.$args;
		}

		return $retval;
	}


	/* Console command to send direct messages to all admins */
	private function console_command_dma($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$query = "SELECT `twitter_user_id` FROM `group_admins` WHERE `group_id`=".$this->id;
		$admins = $this->db->q_fetch_all($query);

		$err = array();

		foreach($admins as $admin) {
			$request = $this->t->direct_messages_new($args, FALSE, FALSE, $admin['twitter_user_id']);

			if(isset($request['error'])) {
				$err[] = array(
					'twitter_user_id' => $admin['twitter_user_id'],
					'error' => $request['error']
				);
			}
		}


		if(count($err)==0) {
			$retval['message'] = 'Sent direct messages to '.count($admins).' admins.';
		} else {
			if(count($err)==count($admins))
				$retval['success'] = FALSE;

			$retval['message'] = 'Unable to send direct messages to '.count($err).' admins.';
		}


		return $retval;
	}


	/* Console command to update hash tags */
	private function console_command_updatehash($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$hashtags = array();

		$args = explode(' ',$args);
		foreach($args as $arg) {
			if($arg[0]!='#') $arg = '#'.$arg;

			$hashtags[] = $arg;
		}


		if(count($hashtags)>0) {
			$query = "UPDATE `groups` SET `hashtags`='".implode(' ',$hashtags)."' WHERE `id`=".$this->id;
			$retval['message'] = 'Updated hash tags to: '.implode(' ',$hashtags);
		} else {
			$retval['success'] = FALSE;
			$retval['message'] = 'No hash tags to update';
		}

		return $retval;
	}


	/* Console command to add hash tags */
	private function console_command_addhash($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$hashtags_new = array();
		$hashtags_current = $this->get_hashtags();

		$args = explode(' ',$args);
		foreach($args as $arg) {
			if($arg[0]!='#') $arg = '#'.$arg;

			if(!in_array($arg, $hashtags_current)) $hashtags_new[] = $arg;
		}


		if(count($hashtags_new)>0) {
			$hashtags = array_merge($hashtags_current, $hashtags_new);

			$retval = $this->console_command_updatehash($hashtags);
		} else {
			$retval['success'] = FALSE;
			$retval['message'] = 'No hash tags provided or no new hash tags provided';
		}


		return $retval;
	}


	/* Console command to delete hash tags */
	private function console_command_delhash($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$hashtags_del = array();
		$hashtags_current = $this->get_hashtags();

		$args = explode(' ',$args);
		foreach($args as $arg) {
			if($arg[0]!='#') $arg = '#'.$arg;

			if(in_array($arg, $hashtags_current)) $hashtags_del[] = $arg;
		}


		if(count($hashtags_del)>0) {
			$hashtags = array_diff($hashtags_current, $hashtags_del);

			$retval = $this->console_command_updatehash($hashtags);
		} else {
			$retval['success'] = FALSE;
			$retval['message'] = 'No hash tags to delete';
		}

		return $retval;
	}


	/* Console command to delete last X posts */
	private function console_command_del($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$args = explode(' ',$args);

		if(count($args)<2) {
			$retval['success'] = FALSE;
			$retval['message'] = "Must specify screen name and number of posts (ALL for all posts)";
		} else {
			$twitter_user_id = $this->t->get_id_by_screenname($args[0]);

			$query = "SELECT `post_status_id` FROM `tweets` WHERE `group_id`=".$this->id." AND `twitter_user_id`='".$twitter_user_id."' ORDER BY `id` DESC";
			if(strtoupper($args[1])!='ALL') $query .= " LIMIT ".intval($args[1]);

			$posts = $this->db->q_fetch_all($query, FALSE, 'post_status_id');
			foreach($posts as $post) {
				$this->t->statuses_destroy($post);
				//echo "del ".$post."\n";
			}

			$retval['message'] = "Deleted ".count($posts)." posts by ".$args[0];
		}

		return $retval;
	}


	/* Console command to block+delete posts by user */
	private function console_command_nuke($args='') {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$retval_block = $this->console_command_block($args);
		$retval_delete = $this->console_command_del($args.' ALL');

		$retval['message'] = $retval_block['message'].', '.$retval_delete['message'];
		print_r($retval);

		return $retval;
	}


	/* Console command to block multiple users */
	private function console_command_multiblock($args) {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$args = explode(' ',$args);

		$retval_block = array();

		if($args>0) {
			foreach($args as $arg)
				$retval_block = $this->console_command_block($arg);

			$retval['message'] = 'Blocked: '.implode(', ',$arg);
		} else {
			$retval['success'] = FALSE;
			$retval['message'] = 'Must provide a screenname to block';
		}
	}


	/* Console command to unblock multiple users */
	private function console_command_multiunblock($args) {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$args = explode(' ',$args);

		$retval_block = array();

		if($args>0) {
			foreach($args as $arg)
				$retval_block = $this->console_command_unblock($arg);

			$retval['message'] = 'Unblocked: '.implode(', ',$arg);
		} else {
			$retval['success'] = FALSE;
			$retval['message'] = 'Must provide a screenname to unblock';
		}
	}


	/* Console command to return help */
	private function console_command_help() {
		$retval = array('success' => TRUE, 'message' => '', 'id' => '');

		$retval['success'] = TRUE;
		$retval['message'] = 'Available commands: u (post update), del (delete), block (block user), nuke (del all + block), hash (start new hashtag), dma (DM admins)';

		return $retval;
	}


	/* Turn group hash tags into an array */
	public function get_hashtags() {
		return explode(' ',$this->opt['hashtags']);
	}


	/* Parse text for words and insert into word bank */
	private function bank_words($text='', $tweet_id=0) {
		$text_arr = str_split(trim(strtolower($text)));
		$text = '';

		foreach($text_arr as $ta)
			if((ord($ta)>=48 && ord($ta)<=57) || (ord($ta)>=97 && ord($ta)<=122))
				$text .= $ta;
			else
				$text .= ' ';


		$words = explode(' ',$text);
		foreach($words as $word) {
			if($word[0]=='#' || $word[0]=='@' || strlen(trim($word))==0)
				continue;

			$query = "SELECT `id` FROM `word_bank` WHERE `word`='".$word."'";
			if(!$wb_id=$this->db->q_result($query, 'id', 0)) {
				$insert = array('word' => $word);
				$wb_id = $this->db->insert('word_bank',$insert);
			}

			$insert = array(
				'tweet_id' => $tweet_id,
				'word_bank_id' => $wb_id
			);

			$this->db->insert('word_bank_tweets', $insert);
		}

		return TRUE;
	}


	/* Parse text for hash tags and insert into hash tag bank */
	private function bank_hashtags($text='', $tweet_id=0) {
		$text_arr = str_split(trim(strtolower($text)));
		$text = '';

		foreach($text_arr as $ta)
			if((ord($ta)>=48 && ord($ta)<=57) || (ord($ta)>=97 && ord($ta)<=122))
				$text .= $ta;
			else
				$text .= ' ';


		$hashtags = explode(' ',$text);
		foreach($hashtags as $ht) {
			if($ht[0]!='#')
				continue;

			$query = "SELECT `id` FROM `hashtag_bank` WHERE `hashtag`='".$ht."'";
			if(!$htb_id=$this->db->q_result($query, 'id', 0)) {
				$insert = array('hashtag' => $ht);
				$htb_id = $this->db->insert('hashtag_bank',$insert);
			}

			$insert = array(
				'tweet_id' => $tweet_id,
				'hashtag_bank_id' => $htb_id
			);

			$this->db->insert('hashtag_bank_tweets', $insert);
		}

		return TRUE;
	}
}
?>
