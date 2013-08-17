<?

if($_p) {
	$_p['user'] = intval($_p['user']);
	$_p['bot'] = intval($_p['bot']);
	
	if($_p['user']==0) $err['user'] = 'Please select a username';
	if($_p['bot']==0) $err['bot'] = 'Please select a bot';
	
	if(!$err) {
		$query = <<<EOQ
UPDATE
	groups
SET
	user_id={$_p['user']}
WHERE
	id={$_p['bot']}
EOQ;
		q($query,$master);
		
		$msg[] = "Bot moved!";
	}
}

$query = "SELECT id,username,firstname,lastname FROM users ORDER BY username DESC";
$result = q($query,$master);
$users = $result->fetchAll();
$result->free();

$query = <<<EOQ
SELECT
	groups.id,
	groups.twitter_screenname,
	users.firstname,
	users.lastname,
	users.username
FROM
	groups
		LEFT OUTER JOIN users
			ON users.id=groups.user_id
ORDER BY
	twitter_screenname DESC
EOQ;
$result = q($query,$master);
$bots = $result->fetchAll();
$result->free();

$smarty->assign('users',$users);
$smarty->assign('bots',$bots);

$title = 'Admin &mdash; Move Bot';
$include = 'movebot';
?>