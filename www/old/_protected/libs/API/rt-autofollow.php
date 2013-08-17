#!/usr/bin/php
<?
require('API.php');

$dev = FALSE;

/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


/* Loop through the accounts */
$bots = array();
$query = "SELECT twitter_screenname FROM groups WHERE id<>29";
$result = mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
	$bots[] = $row['twitter_screenname'];
}


$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups WHERE id=29";
$result = mysql_query($query);
$rtb = mysql_fetch_assoc($result);


$_a = new Account($rtb);

if(check_rate($_a)) {
	$following = array();
	$_u = new User($rtb);
	$friends = $_u->friends(FALSE,'all');
	foreach($friends[0] as $friend) {
		$following[] = trim($friend->screen_name);
	}
}

$diff = array_diff($bots,$following);

foreach($diff as $friend) {
	$_f = new Friendship($rtb);
	$_f->create($friend);
	unset($_f);
}

$_a->end_session();
unset($_a);
unset($_u);


function debug_log($group_id,$cmd,$response) {
	$query = "INSERT INTO debug (group_id,cmd,response) VALUES (".$group_id.",'".addslashes($cmd)."','".addslashes($response)."')";
	mysql_query($query);	
}

function check_rate($_a) {
	$retval = FALSE;
	
	$rate = $_a->rate_limit_status();

	$span = 3600/$rate->{'hourly-limit'};
	$minustime = $span*$rate->{'remaining-hits'};
	$next = $rate->{'reset-time-in-seconds'}-$minustime;

	if(mktime()>=$next) $retval = TRUE;
	
	return $retval;
}
?>
