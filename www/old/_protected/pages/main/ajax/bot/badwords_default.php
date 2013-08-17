<?
$query = "SELECT badword FROM badwords ORDER BY badword";
$result = q($query,$master);
$badwords = $result->fetchAll($result);

$smarty->assign('badwords',$badwords);

$include = 'bot/badwords_default';
?>