<?
$master_dsn = array(
	'db_host' => 'localhost',
	'db_user' => 'retweetbot',
	'db_pass' => 'jkALCT4H',
	'db_name' => 'retweetbot',
	'db_type' => 'mysql'
);

$conn = mysql_connect($master_dsn['db_host'],$master_dsn['db_user'],$master_dsn['db_pass']);
mysql_select_db($master_dsn['db_name'], $conn);

$query = "SELECT MAX(`id`) AS `id` FROM `tweets` WHERE `group_id`=11";
$result = mysql_query($query, $conn);
$since_id = mysql_result($result,'id',0);

$since_id = 'AND `tweets`.`id`>='.($since_id-50);
if(isset($_GET['since_id']) && intval($_GET['since_id'])>0) $since_id = ' AND `tweets`.`id`>'.intval($_GET['since_id']);

$data = array();
$query = <<<EOQ
SELECT
	`tweets`.`id` AS `id`,
	`groups`.`twitter_screenname` AS `group_screenname`,
	`tweets`.`screen_name` AS `user_screenname`,
	`tweets`.`post_status_id`,
	`tweets`.`tweet`,
	`tweets`.`ts`
FROM
	`tweets`
		INNER JOIN `groups` ON
			`groups`.`id`=`tweets`.`group_id` AND
			`groups`.`id`=11
WHERE
	`tweets`.`passed_acl`=1 AND
	`tweets`.`passed_badword`=1 AND
	`tweets`.`passed_blacklist`=1 AND
	`tweets`.`passed_linkfilter`=1
	{$since_id}
ORDER BY
	`tweets`.`ts` ASC
LIMIT 50
EOQ;
$result = mysql_query($query, $conn);
while($row = mysql_fetch_assoc($result)) {
	$data[] = $row;
}

$data = array(
	'success' => true,
	'data' => $data
);

echo json_encode($data);
?>
