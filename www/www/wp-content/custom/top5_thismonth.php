<?
ini_set('display_errors','on');
require 'config.php';

$query = <<<EOQ
SELECT
	`groups`.`twitter_screenname`,
	COUNT(*) AS `count`
FROM
	`groups`
		INNER JOIN `tweets` ON
			`tweets`.`group_id`=`groups`.`id`
WHERE
	MONTH(`tweets`.`ts`)=MONTH(NOW()) AND
	YEAR(`tweets`.`ts`)=YEAR(NOW())
GROUP BY
	`twitter_screenname`
ORDER BY
	`count` DESC
LIMIT 5
EOQ;

$results = mysql_query($query, $db);
while($row=mysql_fetch_assoc($results))
	echo $row['twitter_screenname'].'<br/>';
?>
