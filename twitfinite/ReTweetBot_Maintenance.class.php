<?
/* TO DO
 *  - Make sure prune_tweets() is working correctly
 *  - Create prune_daemon_log()
 */
class ReTweetBot_Maintenance {
	private $date, $dsn, $db;

	function __construct($dsn) {
		$this->dsn = $dsn;
		$this->db_connect();

		$this->date = date('Ymd');
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


	public function prune_tweets() {
		$query = "SELECT MAX(`id`)+1 AS `id` FROM `counts_cache`";
		$auto_increment = $this->db->q_result($query, 0, 'id');


		/* Create a new table to hold most recent tweets by group_id and incoming_type */
		$query = <<<EOQ
CREATE TABLE `tweets_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `status_id` varchar(200) DEFAULT NULL,
  `post_status_id` varchar(200) DEFAULT NULL,
  `incoming_type` enum('reply','dm','friend','follower','list') DEFAULT NULL,
  `twitter_user_id` varchar(200) DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  `tweet` text,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `passed_acl` binary(1) NOT NULL DEFAULT '1',
  `passed_badword` binary(1) NOT NULL DEFAULT '1',
  `passed_blacklist` binary(1) NOT NULL DEFAULT '1',
  `deleted` binary(1) NOT NULL DEFAULT '0',
  `passed_linkfilter` binary(1) NOT NULL DEFAULT '1',
  `geo_place_id` varchar(50) DEFAULT NULL,
  `geo_lat` decimal(50,0) DEFAULT NULL,
  `geo_long` decimal(50,0) DEFAULT NULL,
  `geo_display_coordinates` binary(1) NOT NULL DEFAULT '0',
  `passed_reactivate_cutoff` binary(1) NOT NULL DEFAULT '1',
  `passed_botcheck` binary(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `status_id` (`status_id`),
  KEY `incoming_type` (`incoming_type`),
  KEY `twitter_user_id` (`twitter_user_id`),
  KEY `ts` (`ts`),
  KEY `group_id_incoming_type` (`group_id`,`incoming_type`),
  KEY `group_id_status_id_screen_name` (`group_id`,`status_id`,`screen_name`)
) ENGINE=MyISAM AUTO_INCREMENT={$auto_increment} DEFAULT CHARSET=latin1
EOQ;
		$this->db->q($query);


		/* Copy most recent tweets by group_id and incoming_type */
		$query = <<<EOQ
INSERT INTO `tweets_new` (
	`id`,
	`group_id`,
	`status_id`,
	`post_status_id`,
	`incoming_type`,
	`twitter_user_id`,
	`screen_name`,
	`tweet`,
	`ts`,
	`passed_acl`,
	`passed_badword`,
	`passed_blacklist`,
	`deleted`,
	`passed_linkfilter`,
	`geo_place_id`,
	`geo_lat`,
	`geo_long`,
	`geo_display_coordinates`,
	`passed_reactivate_cutoff`,
	`passed_botcheck`
) SELECT
	`tweets`.`id`,
	`tweets`.`group_id`,
	`tweets`.`status_id`,
	`tweets`.`post_status_id`,
	`tweets`.`incoming_type`,
	`tweets`.`twitter_user_id`,
	`tweets`.`screen_name`,
	`tweets`.`tweet`,
	`tweets`.`ts`,
	`tweets`.`passed_acl`,
	`tweets`.`passed_badword`,
	`tweets`.`passed_blacklist`,
	`tweets`.`deleted`,
	`tweets`.`passed_linkfilter`,
	`tweets`.`geo_place_id`,
	`tweets`.`geo_lat`,
	`tweets`.`geo_long`,
	`tweets`.`geo_display_coordinates`,
	`tweets`.`passed_reactivate_cutoff`,
	`tweets`.`passed_botcheck`
FROM
	`tweets`
		INNER JOIN (SELECT MAX(`id`) AS `id` FROM `tweets` GROUP BY `group_id`,`incoming_type`) AS `t2` ON
			`t2`.`id`=`tweets`.`id`
EOQ;
		$this->db->q($query);


		/* Rename tweets table to tweets_YYYYmmdd */
		$query = "ALTER TABLE `tweets` RENAME `tweets_".$this->date."`";
		$this->db->q($query);

		/* Rename tweets_new to tweets */
		$query = "ALTER TABLE `tweets_new` RENAME `tweets`";
		$this->db->q($query);
	}


	public function prune_counts_cache() {
		$query = "SELECT MAX(`id`)+1 AS `id` FROM `counts_cache`";
		$auto_increment = $this->db->q_result($query, 0, 'id');

		/* Create counts_cache_new */
		$query = <<<EOQ
CREATE TABLE `counts_cache_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `statuses_count` int(11) DEFAULT NULL,
  `friends_count` int(11) DEFAULT NULL,
  `followers_count` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ts` (`ts`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT={$auto_increment} DEFAULT CHARSET=latin1
EOQ;
		$this->db->q($query);


		/* Copy most recent counts from counts_cache to counts_cache_new by group_id */
		$query = <<<EOQ
INSERT INTO `counts_cache_new` (
	`id`,
	`group_id`,
	`statuses_count`,
	`friends_count`,
	`followers_count`,
	`ts`
) SELECT
	`counts_cache`.`id`,
	`counts_cache`.`group_id`,
	`counts_cache`.`statuses_count`,
	`counts_cache`.`friends_count`,
	`counts_cache`.`followers_count`,
	`counts_cache`.`ts`
FROM
	`counts_cache`
		INNER JOIN (SELECT MAX(`id`) AS `id` FROM `counts_cache` GROUP BY `group_id`) AS `cc2` ON
			`cc2`.`id`=`counts_cache`.`id`
EOQ;
		$this->db->q($query);


		/* Rename counts_cache to counts_cache_YYYYmmdd */
		$query = "ALTER TABLE `counts_cache` RENAME `counts_cache_".$this->date."`";
		$this->db->q($query);


		/* Rename counts_cache_new to counts_cache */
		$query = "ALTER TABLE `counts_cache_new` RENAME `counts_cache`";
		$this->db->q($query);
EOQ;
	}


	public function table_to_csv($table=FALSE) {
		$retval = '';

		if(!$table)
			return $table;

		$table = addslashes(stripslashes($table));

		$query = "SHOW TABLES LIKE '".$table."'";

		if($this->db->q_num_rows($query)==0)
			return FALSE;

		$fh = fopen('php://temp','w+');

		$query = "SELECT * FROM `".$table."`";
		$result = $this->db->q($query);
		while($row=$this->db->fetch_assoc($result))
			fputcsv($fh, $row);

		$this->db->free($result);

		rewind($fh);

		while(!feof($fh))
			$retval .= fgets($fh);

		fclose($fh);

		return $retval;
	}


	public function prune_daemon_log() {
		
	}
}

?>