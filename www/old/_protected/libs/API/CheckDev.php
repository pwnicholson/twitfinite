<?
$dev = TRUE;

if(substr_count(dirname(__FILE__),'/opt/retweetbot-daemon')>0) {
	$dev = FALSE;
}
?>
