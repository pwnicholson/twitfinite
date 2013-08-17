<?
if(isset($_p['retweet_restrictions'])) {
	$_p['show_names'] = intval($_p['show_names']);
	$_p['use_replies'] = intval($_p['use_replies']);
	$_p['use_directmessages'] = intval($_p['use_directmessages']);
	$_p['autofollow'] = intval($_p['autofollow']);
	$_p['list_in_directory'] = intval($_p['list_in_directory']);
	$_p['follow_cap'] = intval($_p['follow_cap']);

	if($_p['retweet_restrictions']!='a' && $_p['retweet_restrictions']!='i') $_p['retweet_restrictions'] = '';

	if($_p['badwords_filter']!='b' && $_p['badwords_filter']!='c' && $_p['badwords_filter']!='d') $_p['badwords_filter'] = '';

	if($_p['link_filter']!='b' && $_p['link_filter']!='d') $_p['link_filter'] = '';

	$_p['use_default_badwords'] = (int)$_p['use_default_badwords'];
	$_p['disabled'] = (int)$_p['disabled'];
	$_p['autoappend_ht'] = (int)$_p['autoappend_ht'];
	$_p['console_confirm_dm'] = (int)$_p['console_confirm_dm'];
	$_p['enable_anonymous'] = (int)$_p['enable_anonymous'];
	$_p['autosplit_enabled'] = (int)$_p['autosplit_enabled'];

	if(!isset($_p['oauth'])) {
		if(!$_p['twitter_email']) $err['twitter_email'] = 'You must enter an e-mail address';
		if(!$_p['twitter_screenname']) $err['twitter_screenname'] = 'You must enter a screen name';
		if(!$_p['twitter_password']) $err['twitter_password'] = 'You must enter a password';
	}

	if(!$err && !$_p['delete']) {
		$query = <<<EOQ
UPDATE
	groups
SET
EOQ;
	if(!isset($_p['oauth'])) {
		$query .= <<<EOQ
	twitter_email='{$_p['twitter_email']}',
	twitter_screenname='{$_p['twitter_screenname']}',
	twitter_password='{$_p['twitter_password']}',
EOQ;
	}

	$query .= <<<EOQ
	show_names={$_p['show_names']},
	use_replies={$_p['use_replies']},
	use_directmessages={$_p['use_directmessages']},
	autofollow={$_p['autofollow']},
	retweet_restrictions='{$_p['retweet_restrictions']}',
	descr='{$_p['descr']}',
	list_in_directory='{$_p['list_in_directory']}',
	badwords_filter='{$_p['badwords_filter']}',
	use_default_badwords={$_p['use_default_badwords']},
	follow_cap={$_p['follow_cap']},
	disabled={$_p['disabled']},
	autoappend_ht={$_p['autoappend_ht']},
	hashtags='{$_p['hashtags']}',
	console_confirm_dm={$_p['console_confirm_dm']},
	username_format='{$_p['username_format']}',
	link_filter='{$_p['link_filter']}',
	enable_anonymous={$_p['enable_anonymous']},
	anonymous_username_format='{$_p['anonymous_username_format']}',
	anonymous_username_prepend='{$_p['anonymous_username_prepend']}',
	autosplit_enabled={$_p['autosplit_enabled']},
	autosplit_delimiter='{$_p['autosplit_delimiter']}'
WHERE
	id={$bot_id}
EOQ;
		q($query,$master);
		$msg[] = "Bot updated!";
	} elseif ($_p['delete']) {
		$query = <<<EOQ
DELETE FROM
	groups
WHERE
	id={$bot_id}
EOQ;
		q($query,$master);
		
		$err[] = "Bot deleted!";
		$_s->set('err',$err);
		redirect('/retweet');
	}
}

if($_s->get('admin')==1) {
	$query = "SELECT * FROM groups WHERE id=".$bot_id;
} else {
	$query = "SELECT * FROM groups WHERE id=".$bot_id." AND user_id=".$user_id;
}
if($result = q($query,$master)) {
	$bot = $result->fetchAll();
	$result->free();
	$bot = $bot[0];
	
	$smarty->assign('bot',$bot);
}

$title = "My Bots &mdash; ".$bot['twitter_screenname']." &mdash; Edit";
$title_alt = 'My Bots &mdash; <a href="http://twitter.com/'.$bot['twitter_screenname'].'" target="_blank">'.$bot['twitter_screenname'].'</a> &mdash; Edit';
$include = 'edit';
?>
