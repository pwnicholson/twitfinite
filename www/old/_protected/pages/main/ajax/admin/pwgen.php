<?
$len = 8;
$chars = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';

$pw = '';
for($a=0;$a<$len;$a++) {
	$pw .= $chars[rand(0,strlen($chars))];
}

$smarty->assign('pw',$pw);

$include = 'admin/pwgen';
?>