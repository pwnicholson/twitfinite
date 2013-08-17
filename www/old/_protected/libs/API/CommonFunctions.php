<?
function _log($str,$priority='n') {
	if($priority=='n') {
		$priority = LOG_NOTICE;
	} else {
		$priority = LOG_INFO;
	}

	openlog('retweetbot',LOG_PID|LOG_PERROR,LOG_LOCAL7);
	syslog($priority,$str);
	closelog();
}


/* Turn TRUE/FALSE into 1/0 */
function tf10($bool=FALSE) {
	if($bool) {
		return 1;
	} else {
		return 0;
	}
}


function tweet_it($row, $type='', $status_id=0, $twitter_user_id=0, $twitter_screenname='', $update='', $orig_update='') {
	global $conn, $_s;

	$update = autoappend_hashtags($row,$update);

	$passed_acl = FALSE;
	$passed_badword = FALSE;
	$passed_blacklist = FALSE;
	$passed_linkfilter = FALSE;

	$group_id = $row['group_id'];

	if($type=='dm') {
		_log($row['twitter_screenname'].": Received a new Direct Message (".$status_id.")",'i');
	} elseif ($type=='reply') {
		_log($row['twitter_screenname'].": Received a new @reply (".$status_id.")",'i');
	}

	$passed_acl = check_permissions($group_id,$twitter_user_id);
	if($passed_acl) {
		_log($row['twitter_screenname'].": ".$status_id." passed ACLs",'i');
		check_new_bot($row);
	} else {
		_log($row['twitter_screenname'].": ".$status_id." failed ACLs",'i');
	}

	if($passed_acl) {
		$passed_badword = badword_filter($group_id,$update);
		if($passed_badword) {
			_log($row['twitter_screenname'].": ".$status_id." passed bad word filter",'i');
			$update = $passed_badword;
		} else {
			_log($row['twitter_screenname'].": ".$status_id." failed bad word filter",'i');
		}
	}

	if($passed_badword) {
		$passed_blacklist = blacklist_check($group_id,$twitter_user_id);
		if($passed_blacklist) {
			_log($row['twitter_screenname'].": ".$status_id." passed blacklist",'i');
		} else {
			_log($row['twitter_screenname'].": ".$status_id." failed blacklist",'i');
		}
	}

	if($passed_blacklist) {
		$passed_linkfilter = filter_link($row,$update);
		if($passed_linkfilter) {
			_log($row['twitter_screenname'].": ".$status_id." passed link filter",'i');
			$update = $passed_linkfilter;
		} else {
			_log($row['twitter_screenname'].": ".$status_id." failed link filter",'i');
		}
	}

	$query = "SELECT 1 FROM `tweets`";
	$result = mysql_query($query, $conn);
	if(!$result) die("Database connection went away.\n");

	if($passed_linkfilter) {
		$update_result = $_s->update($update);
		#$update_result->id = 1;  # Comment the line above and uncomment this line for a fake-run just to populate the database
		_log($row['twitter_screenname'].": ".$status_id." posted update (".$update_result->id.")",'i');
	}

	if($update_result->id || !$passed_linkfilter) {
		$passed_acl = tf10($passed_acl);
		$passed_badword = tf10($passed_badword);
		$passed_blacklist = tf10($passed_blacklist);
		$passed_linkfilter = tf10($passed_linkfilter);

		$twitter_screenname = addslashes($twitter_screenname);
		$update = addslashes($update);

		$post_status_id = $update_result->id;
		if(intval($post_status_id)==0) $post_status_id = 0;

		$query = <<<EOQ
INSERT INTO tweets (
	group_id,
	status_id,
	post_status_id,
	screen_name,
	twitter_user_id,
	tweet,
	incoming_type,
	passed_acl,
	passed_badword,
	passed_blacklist,
	passed_linkfilter
) VALUES (
	{$group_id},
	'{$status_id}',
	'{$post_status_id}',
	'{$twitter_screenname}',
	'{$twitter_user_id}',
	'{$update}',
	'{$type}',
	{$passed_acl},
	{$passed_badword},
	{$passed_blacklist},
	{$passed_linkfilter}
)
EOQ;
		mysql_query($query,$conn);

		$tweet_id = mysql_insert_id($conn);

		#$words = find_words($orig_update);
		#if(count($words)>0) wordbank($words,$tweet_id);

		#$hts = find_hts($update);
		#if(count($hts)>0) hashtagbank($hts,$tweet_id);

		#tweet_log($tweet_id);
	}
}


function find_words($str='') {
	$pattern = '/([#A-Za-z0-9_\-]+)/';
	if(preg_match_all($pattern,$str,$matches)) {
		$words = array();
		for($a=0;$a<count($matches[0]);$a++) {
			if($matches[0][$a][0]!='#') $words[] = $matches[0][$a];
		}

		sort($words);
		return $words;
	} else {
		return FALSE;
	}
}


function find_hts($str='') {
	$pattern = '/([#A-Za-z0-9_\-]+)/';
	if(preg_match_all($pattern,$str,$matches)) {
		$hts = array();
		for($a=0;$a<count($matches[0]);$a++) {
			if($matches[0][$a][0]=='#') $hts[] = $matches[0][$a];
		}

		sort($hts);
		return $hts;
	} else {
		return FALSE;
	}
}


function wordbank($words,$tweet_id) {
	global $conn;

	foreach($words as $word) {
		$query = "SELECT id FROM word_bank WHERE word='".$word."'";
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)==0) {
			$query = "INSERT INTO word_bank (word) VALUES ('".$word."')";
			mysql_query($query,$conn);

			$word_id = mysql_insert_id($conn);
		} else {
			$word_id = mysql_result($result,0,'id');
		}

		$query = "SELECT word_bank_id FROM word_bank_tweets WHERE word_bank_id=".$word_id." AND tweet_id=".$tweet_id;
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)==0) {
			$query = "INSERT INTO word_bank_tweets (word_bank_id,tweet_id) VALUES (".$word_id.",".$tweet_id.")";
			mysql_query($query,$conn);
		}
	}
}


function hashtagbank($hts,$tweet_id) {
	global $conn;

	foreach($hts as $ht) {
		$query = "SELECT id FROM hashtag_bank WHERE hashtag='".$ht."'";
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)==0) {
			$query = "INSERT INTO hashtag_bank (hashtag) VALUES ('".$ht."')";
			mysql_query($query,$conn);

			$ht_id = mysql_insert_id($conn);
		} else {
			$ht_id = mysql_result($result,0,'id');
		}

		$query = "SELECT hashtag_bank_id FROM hashtag_bank_tweets WHERE hashtag_bank_id=".$ht_id." AND tweet_id=".$tweet_id;
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)==0) {
			$query = "INSERT INTO hashtag_bank_tweets (hashtag_bank_id,tweet_id) VALUES (".$ht_id.",".$tweet_id.")";
			mysql_query($query,$conn);
		}
	}
}


function autoappend_hashtags($row,$update) {
	if($row['autoappend_ht']==1 && strlen(trim($row['hashtags']))>0) {
		$hashtags = find_hts($update);

		$hashtags_lc = array();
		foreach($hashtags as $hashtag) {
			$hashtags_lc[] = strtolower($hashtag);
		}

		$append_hts = explode(' ',$row['hashtags']);

		foreach($append_hts AS $ht) {
			if(!in_array(strtolower($ht),$hashtags_lc) && (strlen($update)+strlen($ht))<140) {
				$update .= ' '.$ht;
			}
		}
	}

	return $update;
}

function username_format($row,$username) {
	$username = str_replace('%%username%%',$username,$row['username_format']);
	return $username;
}


function check_rate($_a) {
	/* $retval = FALSE;

	$rate = $_a->rate_limit_status();

	$span = 3600/$rate->{'hourly-limit'};
	$minustime = $span*$rate->{'remaining-hits'};
	$next = $rate->{'reset-time-in-seconds'}-$minustime;

	if(mktime()>=$next) $retval = TRUE;

	return $retval; */

	return TRUE;
}


function debug_log($group_id,$cmd,$response) {
	$query = "INSERT INTO debug (group_id,cmd,response) VALUES (".$group_id.",'".addslashes($cmd)."','".addslashes($response)."')";
	mysql_query($query);
}


function get_group_info($group_id=0) {
	global $conn;

	$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups WHERE id=".$group_id;
	$result = mysql_query($query,$conn);
	$row = mysql_fetch_assoc($result);

	return $row;
}


function tweet_log($tweet_id=0) {
        global $conn;   
        
        $query = <<<EOQ
SELECT
        `groups`.`twitter_screenname`,
        `tweets`.`incoming_type`,
        `tweets`.`screen_name`,
        `tweets`.`tweet`,       
        `tweets`.`ts`,   
        `tweets`.`passed_acl`,
        `tweets`.`passed_badword`,
        `tweets`.`passed_blacklist`,
        `tweets`.`passed_linkfilter`,
        `tweets`.`deleted`
FROM
        `tweets`
                INNER JOIN `groups` ON
                        `groups`.`id`=`tweets`.`group_id`
WHERE
        `tweets`.`id`={$tweet_id}
EOQ;
        $result = mysql_query($query, $conn);
        if(mysql_num_rows($result)>0) {
                $row = mysql_fetch_assoc($result);

                $status = 'passed';

                if($row['passed_acl']==0) $status = 'failed_acl';
                if($row['passed_badword']==0) $status = 'failed_badword';
                if($row['passed_blacklist']==0) $status = 'failed_blacklist';
                if($row['passed_linkfilter']==0) $status = 'failed_linkfilter';

                $str = $row['screen_name'].' ['.$row['ts'].'] '.$status.' '.strlen($row['tweet']).' '.$row['twitter_screenname'].' retweetbotlog';

                _log($str);
	}
}
?>
