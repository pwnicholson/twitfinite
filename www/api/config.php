<?php

/**
 * @file
 * A single location to store configuration.
 */

ini_set('display_errors','on');

session_start();
require_once('twitteroauth/twitteroauth/twitteroauth.php');
require_once('config.php');


$db = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot', $db);


$query = "SELECT * FROM `config`";
$result = mysql_query($query);
while($row=mysql_fetch_assoc($result))
	define($row['var'], $row['val']);

#define('CONSUMER_KEY', 'iYjHQFOK5tIzbW3BGP3AA');
#define('CONSUMER_SECRET', 'WofaCqlDPJYNaVDySpkmMmAxeA05sMDBJJDwUcnumc');
#define('OAUTH_CALLBACK', 'http://api.twitfinite.com/callback.php');
