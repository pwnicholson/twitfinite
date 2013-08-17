<?php
require_once 'config.php';


/* If access tokens are not available redirect to connect page. */
#if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
#    header('Location: ./clearsessions.php');
#}


if($_SESSION['status']!='verified')
	header('location: redirect.php');


$conn = new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$_SESSION['access_token']['oauth_token'],$_SESSION['access_token']['oauth_token_secret']);
$creds = $conn->get('account/verify_credentials');


$query = "SELECT `id` FROM `groups` WHERE `twitter_user_id`=".$creds->id;
$result = mysql_query($query, $db);
if(mysql_num_rows($result)==0) {
	$query = "UPDATE `groups` SET `twitter_user_id`='".$creds->id."' WHERE `twitter_screenname`='".$creds->screen_name."'";
	mysql_query($query, $db);
}


$query = "UPDATE `groups` SET `oauth_token`='".$_SESSION['access_token']['oauth_token']."', `oauth_secret`='".$_SESSION['access_token']['oauth_token_secret']."' WHERE `twitter_user_id`='".$creds->id."'";
mysql_query($query, $db);


session_destroy();

header('location: http://www.retweetbot.com');