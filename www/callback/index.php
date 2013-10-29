<?php
ini_set('display_errors','on');
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);


/* If method is set change API call made. Test is called by default. */
$content = $connection->get('account/verify_credentials');

/* If we're not authed */
if(isset($content->error)) {
	header('location: redirect.php');
	exit;
}


/* Update the database */
$db = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot', $db);

if(isset($connection->token->key) && isset($connection->token->secret)) {
	#$query = "UPDATE `groups` SET `oauth_token`='".$connection->token->key."', `oauth_secret`='".$connection->token->secret."' WHERE `twitter_screenname`='".$content->screen_name."'";
	#mysql_query($query, $db);
}
