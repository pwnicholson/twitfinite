<?
$require_path = dirname(__FILE__).'/';
require $require_path.'ReTweetBot.config.php';
require $require_path.'ReTweetBot.functions.php';
require $require_path.'DB.class.php';
//require 'cURL.class.php';
require $require_path.'ReTweetBot.class.php';
require $require_path.'ReTweetBot_Periodic.class.php';
require $require_path.'ReTweetBot_Maintenance.class.php';
require $require_path.'ReTweetBot_Daemon.class.php';
require $require_path.'twitteroauth/twitteroauth.php';
require $require_path.'Twitter.class.php';


$daemon =& new ReTweetBot_Daemon($retweetbot_dsn);

if(isset($debug_bots) && count($debug_bots)>0)
	$daemon->debug_bots = $debug_bots;

if(isset($_SERVER['argv'][1]) && is_numeric($_SERVER['argv'][1]))
	$daemon->start($_SERVER['argv'][1]);
else
	$daemon->start();

echo "\n";
?>