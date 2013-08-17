<?
require('recaptchalib.php');

$publickey = "6LcyIAUAAAAAAGjjwpxSGDYoFptYxVgMxErKSk_N"; // you got this from the signup page
$captcha = recaptcha_get_html($publickey);
$smarty->assign('captcha',$captcha);

if($_p) {
	if(!$_p['firstname']) $err['firstname'] = "Please include your first name.";
	if(!$_p['lastname']) $err['lastname'] = "Please include your last name.";
	if(!$_p['email']) $err['email'] = "Please include your e-mail address.";
	if(!$_p['message']) $err['message'] = "Please include a message.";
	
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
		$from = "info+contact@retweetbot.com";
		$to = "info+contact@retweetbot.com";
		$subject = "ReTweetBot.com Contact Us -- ".$_p['firstname']." ".$_p['lastname']." (".$_p['email'].")";
		$message = <<<EOM
A new person has sent a "Contact Us" message.

Here are the details:
First name: {$_p['firstname']}
Last name: {$_p['lastname']}
E-mail address: {$_p['email']}

Message:
{$_p['message']}

IP Address: {$ip}
Timestamp: {$ts}
EOM;
		$headers = "From: ".$from."\r\nReply-To: ".$_p['email']."\r\n";
		
		mail($to, $subject, $message, $headers);
		
		$msg[] = "Your message been sent!  We should be able to respond to you within a couple of days.";
	}
}

if(!$_p && $_s->get('user_id')) { 
	$query = "SELECT firstname,lastname,email FROM users WHERE id=".$_s->get('user_id');
	$result = q($query,$master);
	$user = $result->fetchAll();
	$result->free();
	
	$_p = $user[0];
}
?>