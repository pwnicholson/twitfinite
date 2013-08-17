<?
if($_s->get('admin')==1) {
	$where = "";
} else {
	$where = " AND groups.user_id=".$_s->get('user_id');
}

$_s->set('bot_id',$bot_id);


$query = <<<EOQ
SELECT
	groups.id AS group_id,
	groups.twitter_screenname AS twitter_screenname,
	COUNT(DISTINCT tweets.screen_name) AS screenname_count,
	users.username AS username,
	users.firstname AS firstname,
	users.lastname AS lastname
FROM
	groups
		LEFT OUTER JOIN tweets
			ON tweets.group_id=groups.id
		LEFT OUTER JOIN users
			ON users.id=groups.user_id
WHERE
	groups.id={$bot_id}
	{$where}
GROUP BY
	groups.id,
	groups.name
ORDER BY
	groups.name
EOQ;

if($result = q($query,$master)) {
	$bot = $result->fetchAll();
	$bot = $bot[0];
	$result->free();
	
	$smarty->assign('screenname_count',number_format($bot['screenname_count']));
	$smarty->assign('status_updates',number_format($bot['updates']));
	$smarty->assign('bot',$bot);
}


$query = <<<EOQ
SELECT
	friends_count,
	followers_count,
	statuses_count
FROM
	counts_cache
WHERE
	group_id={$bot_id}
ORDER BY
	ts DESC
LIMIT 1
EOQ;
$result = q($query,$master);
$counts_cache = $result->fetchAll();
$result->free();

$smarty->assign('friends_count',number_format($counts_cache[0]['friends_count']));
$smarty->assign('followers_count',number_format($counts_cache[0]['followers_count']));
$smarty->assign('statuses_count',number_format($counts_cache[0]['statuses_count']));


$title = 'My Bots &mdash; '.$bot['twitter_screenname'];
$title_alt = 'My Bots &mdash; <a href="http://twitter.com/'.$bot['twitter_screenname'].'" target="_blank">'.$bot['twitter_screenname'].'</a> &mdash; Summary';

$include = 'summary';
?>