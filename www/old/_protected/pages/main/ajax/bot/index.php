<?
$bot_id = (int)$url[3];

if($_s->get('admin')==1) {
	$where = "";
} else {
	$where = " AND user_id=".$_s->get('user_id');
}

$query = "SELECT id FROM groups WHERE id=".$bot_id.$where;
$result = q($query,$master);
$admin = $result->fetchAll();
if(count($admin)==0) {
	die("Hack attempt...denied");
}

switch($url[2]) {
	case 'post_update':
		require('post_update.php');
		break;
	case 'admin_users':
		require('admin_users.php');
		break;
	case 'include_users':
		require('include_users.php');
		break;
	case 'badwords':
		require('badwords.php');
		break;
	case 'blacklist':
		require('blacklist.php');
		break;
	case 'badwords_default':
		require('badwords_default.php');
		break;
}
?>