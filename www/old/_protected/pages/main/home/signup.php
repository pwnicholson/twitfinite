<?
require('recaptchalib.php');

$publickey = "6LcyIAUAAAAAAGjjwpxSGDYoFptYxVgMxErKSk_N"; // you got this from the signup page
$captcha = recaptcha_get_html($publickey);
$smarty->assign('captcha',$captcha);

if($_p) {
	if(!$_p['firstname']) $err['firstname'] = "Please include your first name.";
	if(!$_p['lastname']) $err['lastname'] = "Please include your last name.";
	if(!$_p['email']) $err['email'] = "Please include your e-mail address.";
	if(!$_p['twitter_bot']) $err['twitter_bot'] = "Please include your bot's Twitter screen name.";
	if(!$_p['about_bot']) $err['about_bot'] = "Please include a description of your bot.";
	
	$privatekey = "6LcyIAUAAAAAADpiyxIm_9kMNJutLLtguy2CMWOQ";
	$resp = recaptcha_check_answer ($privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
		
	if(!$resp->is_valid) {
		$err['captcha'] = "Invalid captcha.  Error code: \"".$resp->error."\"";
	}
	
	if(!$err) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$ts = date("Y-m-d H:i:s");
		$from = "info+signups@retweetbot.com";
		$to = "info+signups@retweetbot.com";
		$subject = "ReTweetBot.com Sign-Up -- ".$_p['firstname']." ".$_p['lastname']." (".$_p['email'].")";
		$message = <<<EOM
A new person has requested a ReTweetBot.com account.

Here are the details:
First name: {$_p['firstname']}
Last name: {$_p['lastname']}
E-mail address: {$_p['email']}
Bot name: {$_p['twitter_bot']}

Bot description:
{$_p['about_bot']}

How they heard about us: {$_p['how_did_you_hear']}

IP Address: {$ip}
Timestamp: {$ts}
EOM;
		$headers = "From: ".$from."\r\nReply-To: ".$_p['email']."\r\n";
		
		mail($to, $subject, $message, $headers);
		
		$msg[] = "Your sign-up request has been sent!  We should be able to respond to you within a couple of days.";
	}
}
?>