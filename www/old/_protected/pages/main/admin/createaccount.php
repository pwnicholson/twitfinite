<?
if($_p) {
	if(!$_p['firstname']) $err['firstname'] = 'Please enter a first name';
	if(!$_p['lastname']) $err['lastname'] = 'Please enter a last name';
	if(!$_p['email']) $err['email'] = 'Please enter an e-mail address';
	if(!$_p['username']) $err['username'] = 'Please enter a unique username';
	
	$query = "SELECT username FROM users WHERE username='".$_p['username']."'";
	$result = q($query,$master);
	$user = $result->fetchAll();
	$result->free();
	
	if(count($user)>0) {
		$err['username'] = 'That username already exists';
	}
	
	if($_p['password']!=$_p['confirm']) $err['password'] = 'The passwords do not match';
	
	if($_p['admin']=='Y') {
		$_p['admin'] = 1;
	} else {
		$_p['admin'] = 0;
	}
	
	if(!$err) {
		$query = <<<EOQ
INSERT INTO users (
	firstname,
	lastname,
	email,
	username,
	password,
	admin
) VALUES (
	'{$_p['firstname']}',
	'{$_p['lastname']}',
	'{$_p['email']}',
	'{$_p['username']}',
	PASSWORD('{$_p['password']}'),
	{$_p['admin']}
)
EOQ;
		q($query,$master);
		
		$msg[] = "Account created!";
		
		if($_p['send_email']) {
			$from = 'ReTweetBot.com <info@retweetbot.com>';
			$to = $_p['firstname'].' '.$_p['lastname'].' <'.$_p['email'].'>';
			$subject = 'Your ReTweetBot.com Account is Set Up!';
			$body = <<<EOQ
Your account is set up!  Here are your login credentials:

http://www.retweetbot.com/home/login
Username: {$_p['username']}
Password: {$_p['password']}

Once you log in, you need to setup your bot using the new Twitter account's login info.  You can also change your login password under the My Accounts section.

Thanks!
Paul and Garrett
The ReTweetBot Crew
info@retweetbot.com	
EOQ;

			$headers = "From: ".$from."\r\nReply-To: info@retweetbot.com\r\nBcc: info@retweetbot.com";
			@mail($to,$subject,$body,$headers);
			$msg[] = "E-mail sent!";
		}
	}
}

$title = 'Admin &mdash; Create Account';
$onload = "$('firstname').focus()";
$include = 'createaccount';
?>