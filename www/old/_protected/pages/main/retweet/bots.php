<?
if(eregi('pages/main/home/index.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

if(!$_s->get('user_id')) redirect('login');

if($_s->get('admin')==1) {
	$where = "";
} else {
	$where = " WHERE groups.user_id=".$_s->get('user_id');
}


$query = <<<EOQ
SELECT
	`groups`.`id` AS `group_id`,
	`groups`.`twitter_screenname` AS `twitter_screenname`,
	COUNT(DISTINCT `tweets`.`screen_name`) AS `screenname_count`
FROM
	`groups`
		LEFT OUTER JOIN `tweets` ON
			`tweets`.`group_id`=`groups`.`id` AND
			`tweets`.`passed_acl`=1
{$where}
GROUP BY
	`groups`.`id`,
	`groups`.`twitter_screenname`
ORDER BY
	`groups`.`twitter_screenname`
EOQ;

if($result = q($query,$master)) {
	$groups = $result->fetchAll();
	$result->free();
	
	for($a=0;$a<count($groups);$a++) {
		$query = <<<EOQ
SELECT
	friends_count,
	followers_count,
	statuses_count
FROM
	counts_cache
WHERE
	group_id={$groups[$a]['group_id']}
ORDER BY
	ts DESC
LIMIT 1
EOQ;
		$result = q($query,$master);
		$counts_cache = $result->fetchAll();
		$result->free();
		
		$groups[$a]['friends_count'] = number_format($counts_cache[0]['friends_count']);
		$groups[$a]['followers_count'] = number_format($counts_cache[0]['followers_count']);
		$groups[$a]['statuses_count'] = number_format($counts_cache[0]['statuses_count']);
	}
	
	$smarty->assign('groups',$groups);
}

$title = 'My Bots';

$include = 'index';
?>
