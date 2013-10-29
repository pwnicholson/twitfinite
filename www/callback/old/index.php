<?
ini_set('display_errors','on');
error_reporting(E_ALL);

$db = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot', $db);

$query = 'SELECT * FROM groups WHERE id=12';
$result = mysql_query($query);
$group = mysql_fetch_assoc($result);

if($group['oauth_state']==1 && !isset($_GET['oauth_token']))
	$group['oauth_state'] = 0;

$o = new OAuth('iYjHQFOK5tIzbW3BGP3AA','WofaCqlDPJYNaVDySpkmMmAxeA05sMDBJJDwUcnumc',OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
$o->enableDebug();

if($group['oauth_state']==0) {
	$request_token_info = $o->getRequestToken('http://api.twitter.com/oauth/request_token');
	$oauth_token = $request_token_info['oauth_token'];
	$oauth_secret = $request_token_info['oauth_token_secret'];
	$oauth_state = 1;

	$query = "UPDATE groups SET oauth_token='".$oauth_token."', oauth_secret='".$oauth_secret."', oauth_state=1 WHERE id=".$group['id'];
	mysql_query($query);

	header("Location: http://twitter.com/oauth/authorize?oauth_token=".$oauth_token);
} elseif($group['oauth_state']==1) {
	$o->setToken($_GET['oauth_token'], $group['oauth_secret']);
	$access_token_info = $o->getAccessToken("http://api.twitter.com/1/oauth/access_token");
	$oauth_state = 2;
	$oauth_token = $access_token_info['token'];
	$oauth_secret = $access_token_info['secret'];

	#$query = "UPDATE groups SET oauth_token='".$oauth_token."', oauth_secret='".$oauth_state."', oauth_state=2 WHERE id=".$group['id'];
	#mysql_query($query); */
}


pr($group);
$o->setToken($group['oauth_token'], $group['oauth_secret']);


#$o->fetch("http://api.twitter.com/1/statuses/home_timeline.json");
#$o->fetch("http://api.twitter.com/1/account/verify_credentials.json");
#$json = json_decode($oauth->getLastResponse());


function pr($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}
?>
