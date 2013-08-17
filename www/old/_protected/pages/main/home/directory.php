<?
$query = <<<EOQ
SELECT
	*
FROM
	groups
WHERE
	list_in_directory=1 AND
	id NOT IN (12) AND
	LENGTH(descr)>0
ORDER BY
	twitter_screenname
EOQ;
$result = q($query,$master);
$directory = $result->fetchAll();

for($a=0;$a<count($directory);$a++) {
	$directory[$a]['descr'] = autolink_url($directory[$a]['descr']);
	$directory[$a]['descr'] = autolink_twitter($directory[$a]['descr']);
}

$smarty->assign('directory',$directory);
?>