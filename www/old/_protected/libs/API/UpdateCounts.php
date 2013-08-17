#!/usr/bin/php
<?
require('API.php');
require('CommonFunctions.php');

_log("Start ".realpath($_SERVER['PHP_SELF']),'n');

$dev = FALSE;

/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


/* Loop through the accounts */
$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups";
$result = mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
	$_a = new Account($row);
	$_u = new User($row);

	if(check_rate($_a)) {
		$show = $_u->show($row['twitter_screenname']);
		_log("Checking ".$row['twitter_screenname'],'n');
		
		if((int)$show->id>0) {
			_log($row['twitter_screenname'].": update status=".$show->statuses_count.", friends=".$show->friends_count.", follower=".$show->followers_count,'i');
			$query = <<<EOQ
INSERT INTO counts_cache (
	group_id,
	friends_count,
	followers_count,
	statuses_count
) VALUES (
	{$row['group_id']},
	{$show->friends_count},
	{$show->followers_count},
	{$show->statuses_count}
)
EOQ;
			mysql_query($query);
		}
	}
}

_log("End ".realpath($_SERVER['PHP_SELF']),'n');
?>
