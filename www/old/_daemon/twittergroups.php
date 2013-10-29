#!/usr/bin/php
<?
#if(eregi('twittergroups.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

#$dev = TRUE;
$dev = FALSE;

/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


/* Set testing options for URLS */
if($dev) {
	$url = "http://twittergroups.munkeesoft.com/";
} else {
	$url = "http://twitter.com/statuses/";
}

/* Where is CURL? */
$curl = '/usr/bin/curl -s --stderr /dev/null -H "Pragma: no-cache" -H "Cache-control: no-cache"';

/* Template Variables */
$templates['followers_xml'] = $curl." -u %%twitter_email%%:%%twitter_password%% ".$url."followers.xml";
$templates['update_xml'] = $curl." -u %%twitter_email%%:%%twitter_password%% -d status=\"%%status%%\" ".$url."update.xml";
$templates['rate_limit_status_xml'] = $curl." -u %%twitter_email%%:%%twitter_password%% http://twitter.com/account/rate_limit_status.xml";
$templates['replies_xml'] = $curl." -u %%twitter_email%%:%%twitter_password%% ".$url."replies.xml";
$templates['directmessages_xml'] = $curl." -u %%twitter_email%%:%%twitter_password%% http://twitter.com/direct_messages.xml";

/* Loop through the accounts */
$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups";
$result = mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
	if($row['use_replies']==1) {
		$output = '';
		$rate = do_call($templates['rate_limit_status_xml'],$row);

		$span = 3600/$rate->{'hourly-limit'};
		$minustime = $span*$rate->{'remaining-hits'};
		$next = $rate->{'reset-time-in-seconds'}-$minustime;

		if(mktime()>=$next) {
			$replies_xml = do_call($templates['replies_xml'],$row);
			if(@$replies_xml->error) die();

			foreach($replies_xml->status as $status) {
				$query = "SELECT id FROM tweets WHERE group_id=".$row['group_id']." AND status_id='".addslashes($status->id)."' AND screen_name='".addslashes($status->user->screen_name)."'";
				$result2 = mysql_query($query);
				if(mysql_num_rows($result2)==0) {
					#$row['status'] = trim(str_ireplace('@'.$row['twitter_screenname'],'',str_replace('"','\"',$status->text)));
					$row['status'] = str_ireplace('@'.$row['twitter_screenname'],'',$status->text);
					$row['status'] = urlencode($row['status']);
					if($row['show_names']==1) $row['status'] = $status->user->screen_name.': '.$row['status'];

					do_call($templates['update_xml'],$row,TRUE);

					$query = "INSERT INTO tweets (group_id,status_id,screen_name) VALUES (".$row['group_id'].",'".addslashes($status->id)."','".addslashes($status->user->screen_name)."')";
					mysql_query($query);
				}
			}
		}
	}

	if($row['use_directmessages']==1) {
		$output = '';
		$rate = do_call($templates['rate_limit_status_xml'],$row);

		$span = 3600/$rate->{'hourly-limit'};
		$minustime = $span*$rate->{'remaining-hits'};
		$next = $rate->{'reset-time-in-seconds'}-$minustime;

		if(mktime()>=$next) {
			$directmessages_xml = do_call($templates['directmessages_xml'],$row);
			if(@$directmessages_xml->error) die('there was an error with directmessages_xml');

			foreach($directmessages_xml->direct_message as $status) {
				$query = "SELECT id FROM tweets WHERE group_id=".$row['group_id']." AND status_id='".addslashes($status->id)."' AND screen_name='".addslashes($status->sender->screen_name)."'";
				$result2 = mysql_query($query);
				if(mysql_num_rows($result2)==0) {
					#$row['status'] = trim(str_ireplace('@'.$row['twitter_screenname'],'',str_replace('"','\"',$status->text)));
					$row['status'] = str_ireplace('@'.$row['twitter_screenname'],'',$status->text);
					$row['status'] = urlencode($row['status']);
					if($row['show_names']==1) $row['status'] = $status->sender->screen_name.': '.$row['status'];

					do_call($templates['update_xml'],$row,TRUE);

					$query = "INSERT INTO tweets (group_id,status_id,screen_name) VALUES (".$row['group_id'].",'".addslashes($status->id)."','".addslashes($status->sender->screen_name)."')";
					mysql_query($query);
				}
			}
		}
	}

}


/* Functions */
function template_replace($template='',$arr) {
	$keys = array_keys($arr);

	for($a=0;$a<count($keys);$a++) {
		$template = str_replace('%%'.strtolower($keys[$a]).'%%',$arr[$keys[$a]],$template);
	}

	return $template;
}

function do_call($template,$arr,$debug=FALSE) {
	$cmd = template_replace($template,$arr);
	echo $cmd."\n";
	exec($cmd,$output);

	$output = implode("\n",$output);
	echo $output."\n";

	$output = str_ireplace('<?xml version="1.0" encoding="UTF-8"?>','',$output);
	$output = '<?xml version="1.0" encoding="UTF-8"?> '.$output;

	if($debug) debug_log($arr['group_id'],$cmd,$output);

	return new SimpleXMLElement($output);
}

function debug_log($group_id,$cmd,$response) {
	$query = "INSERT INTO debug (group_id,cmd,response) VALUES (".$group_id.",'".addslashes($cmd)."','".addslashes($response)."')";
	mysql_query($query);	
}
?>
