<?
$title = 'Add New Bot';
$onload = "$('twitter_screenname').focus()";
$include = 'add';

if($_p) {
	$_p['show_names'] = intval($_p['show_names']);
	$_p['use_replies'] = intval($_p['use_replies']);
	$_p['use_directmessages'] = intval($_p['use_directmessages']);
	$_p['autofollow'] = intval($_p['autofollow']);
	
	if($_p['retweet_restrictions']!='a' && $_p['retweet_restrictions']!='i') $_p['retweet_restrictions'] = '';
	
	if(!$_p['twitter_email']) $err['twitter_email'] = 'You must enter an e-mail address';
	if(!$_p['twitter_screenname']) $err['twitter_screenname'] = 'You must enter a screen name';
	if(!$_p['twitter_password']) $err['twitter_password'] = 'You must enter a password';
	
	if(!$err) {
		$query = <<<EOQ
INSERT INTO groups (
	user_id,
	twitter_email,
	twitter_screenname,
	twitter_password,
	show_names,
	use_replies,
	use_directmessages,
	autofollow,
	retweet_restrictions
) VALUES (
	{$user_id},
	'{$_p['twitter_email']}',
	'{$_p['twitter_screenname']}',
	'{$_p['twitter_password']}',
	{$_p['show_names']},
	{$_p['use_replies']},
	{$_p['use_directmessages']},
	{$_p['autofollow']},
	'{$_p['retweet_restrictions']}'
)
EOQ;
		q($query,$master);
		
		$query = "SELECT id FROM groups WHERE user_id=".$user_id." AND twitter_screenname='".$_p['twitter_screenname']."' ORDER BY id DESC LIMIT 1";
		$result = q($query,$master);
		$bot = $result->fetchAll();
		$result->free();
		
		redirect($bot[0]['id'].'/edit');
	}
}
?>