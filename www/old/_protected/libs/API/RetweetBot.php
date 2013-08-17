#!/usr/bin/php
<?
require 'CheckDev.php';

/* Define command-line options */
$options = getopt('i::e::h');


/* Print the help message for -h */
if(isset($options['h'])) {
	echo "Options are:\n\t-i\tRun only bot ID(s) specified (comma-separated)\n\t-e\tRun all bots except bot ID(s) specified (comma-separated)\n\t-h\tThis help\n";
	echo "\nExamples:\n\t".basename(__FILE__)." -i1234,5678\tInclude bot IDs 1234 and 5678\n";
	echo "\t".basename(__FILE__)." -e1234,5678\tExclude bot IDs 1234 and 5678\n";
	exit;
}



/* Process included bot IDs for -i */
$include = '';  $include_arr = array();
if(isset($options['i']))
	$include_arr = explode(',',$options['i']);


/* Process excluded bot IDs for -e */
$exclude = '';  $exclude_arr = array();
if(isset($options['e']))
	$exclude_arr = explode(',',$options['e']);


/* Check for dev, include if it is, exclude if it isn't */
if($dev) {
	$include_arr[] = 12;
} else {
	$exclude_arr[] = 12;
}


/* Turn includes and excludes into query-ready strings */
/* Unset invalid included bot IDs */
foreach($include_arr as $k => $v) {
	if(intval($v)==0)
		unset($include_arr[$k]);
}

/* Turn includes into a string */
if(count($include_arr)>0) {
	$include = 'AND groups.id IN ('.implode(',',$include_arr).')';
} else {
	$include = '';
}

/* Unset invalid excluded bot IDs */
foreach($exclude_arr as $k => $v) {
	if(intval($v)==0)
		unset($exclude_arr[$k]);
}

/* Turn excludes into a string */
if(count($exclude_arr)>0) {
	$exclude = 'AND groups.id NOT IN ('.implode(',',$exclude_arr).')';
} else {
	$exclude = '';
}


/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


/* Require more stuff */
require 'CommonFunctions.php';
require 'API.php';
require 'Console.php';
require 'Permissions.php';
require 'RetweetDMs.php';
require 'RetweetReplies.php';
require 'CheckNewBot.php';
require 'BadWordFilter.php';
require 'Blacklist.php';
require 'LinkFilter.php';


/* Make sure we aren't running too many processes */
$num_processes = `ps aux | grep -i 'retweetbot.php' | grep -v 'grep' | wc -l`;
if($num_processes>4 && !$dev) {
	_log("Did not start.  Too many processes already running.",'n');
	exit();
}


_log("Start ".realpath($_SERVER['PHP_SELF']),'n');


/* Loop through the accounts */
if($dev) {
	if($bot==0) $bot = 12;
	$query = <<<EOQ
SELECT
	groups.id AS group_id,
	groups.*
FROM
	groups
WHERE
	LENGTH(LTRIM(RTRIM(`oauth_token`)))=0 AND
	LENGTH(LTRIM(RTRIM(`oauth_secret`)))=0 AND
	disabled=0
	{$include}
	{$exclude}
EOQ;
} else {
	$query = <<<EOQ
SELECT
	groups.id AS group_id,
	groups.*
FROM
	groups
WHERE
	LENGTH(LTRIM(RTRIM(`oauth_token`)))=0 AND
	LENGTH(LTRIM(RTRIM(`oauth_secret`)))=0 AND
	disabled=0
	{$include}
	{$exclude}
EOQ;
}
$result = mysql_query($query,$conn);
while($row=mysql_fetch_assoc($result)) {
	_log("Checking bot ".$row['twitter_screenname'],'n');
	$_a = new Account($row);

	#$vc_xml = $_a->verify_credentials();
	$vc_xml = TRUE;

	if(@!$vc_xml->error) {
		$_s = new Status($row);
		
		replies($row);
		dms($row);

		$query = "UPDATE groups SET last_check='".date("Y-m-d H:i:s")."' WHERE id=".$row['group_id'];
		mysql_query($query);

		$_a->end_session();
		unset($_a);
		unset($_s);
	} else {
		_log($row['twitter_screenname']." error: ".$vc_xml->error);
	}
}

_log("End ".realpath($_SERVER['PHP_SELF']),'n');
?>
