<?

$query = <<<EOQ
SELECT
	users.id,
	firstname,
	lastname,
	username,
	COUNT(groups.id) AS bot_count
FROM
	users
		LEFT OUTER JOIN groups
			ON groups.user_id=users.id
GROUP BY
	firstname,
	lastname,
	username
ORDER BY
	firstname ASC,
	lastname ASC
EOQ;
$result = q($query,$master);
$users = $result->fetchAll();
$result->free();

$smarty->assign('users',$users);

$title = 'Admin &mdash; List Users';
$include = 'listusers';
?>