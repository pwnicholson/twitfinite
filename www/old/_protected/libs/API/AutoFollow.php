#!/usr/bin/php
<?
require('API.php');
require('CommonFunctions.php');
require('Blacklist.php');

_log("Start ".realpath($_SERVER['PHP_SELF']),'n');

/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


$date = date("Y-m-d H:i:s");

/* Loop through the accounts */
$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages,follow_cap FROM groups WHERE autofollow=1 AND next_autofollow<='".$date."' OR next_autofollow IS NULL";
$result = mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
	$_a = new Account($row);
	$_sg = new SocialGraph($row);
	
	if(check_rate($_a)) {
		_log("Checking ".$row['twitter_screenname'],'n');
		$_u = new User($row);
		$followers = $_sg->followers($row['twitter_screenname']);
		$friends = $_sg->friends($row['twitter_screenname']);
	}

	$fol = array();
	foreach($followers->id as $follower) {
		$fol[] = trim($follower);
	}
	
	$fri = array();
	foreach($friends->id as $friend) {
		$fri[] = trim($friend);
	}
	
	$diff = array_diff($fol,$fri);
	
	$followed = array();
	$query = "SELECT twitter_user_id FROM groups_followed WHERE group_id=".$row['group_id'];
	$result2 = mysql_query($query);
	while($row2=mysql_fetch_assoc($result2)) {
		$followed[] = $row2['twitter_user_id'];
	}

	$error = FALSE;	
	foreach($diff as $friend) {
		$follow = TRUE;
		if(in_array($friend,$followed)) {
			$follow = FALSE;
			_log($row['twitter_screenname'].": Not following ".$friend.".  Already recorded as being followed.",'i');
		}
		
		$follow = blacklist_check($row['group_id'],$friend);
		if($follow && in_array($friend,$followed)) $follow = FALSE;
		
		if($follow && $row['follow_cap']>0) {
			$prospect = $_u->show($friend);
			if($prospect->followers_count>$row['follow_cap']) {
				_log($row['twitter_screenname'].": Not following ".$friend.".  Follower count (".$prospect->followers_count.") is greater than cap (".$row['follow_cap'].").",'i');
				$follow = FALSE;
			}
		}
		
		if($follow && !$error) {
			$_f = new Friendship($row);
			$test = $_f->create($friend);
			
			if(isset($test->error) && substr_count($test->error,"You've already requested to follow")==0) {
				$error = TRUE;
				_log($row['twitter_screenname'].": Error: ".$test->error,'i');
				$query = "UPDATE groups SET next_autofollow='".date("Y-m-d H:i:s",mktime((date("H")+24),date("i"),date("s"),date("n"),date("j"),date("Y")))."' WHERE id=".$row['group_id'];
				mysql_query($query);
				break;
			}

			if($follow && !$error) _log($row['twitter_screenname'].": following ".$friend,'i');
			
			$query = "INSERT INTO groups_followed (group_id,twitter_user_id) VALUES (".$row['group_id'].",'".$friend."')";
			mysql_query($query);
			
			unset($_f);
		}
	}

	if($follow && !$error) {
		$query = "UPDATE groups SET next_autofollow='".date("Y-m-d H:i:s")."' WHERE id=".$row['group_id'];
		mysql_query($query);
	}

	$_a->end_session();
	unset($_a);
	unset($_u);
}

_log("End ".realpath($_SERVER['PHP_SELF']),'n');
?>
