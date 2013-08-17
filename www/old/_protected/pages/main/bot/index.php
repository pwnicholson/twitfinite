<?
if(!$_s->get('user_id')) {
	redirect('/home/login');
}

$user_id = $_s->get('user_id');
$bot_id = intval($url[1]);
if($bot_id>0) $smarty->assign('bot_id',$bot_id);


$query = <<<EOQ
SELECT
	*
FROM
	groups
WHERE
	id={$bot_id}
EOQ;
$result = q($query,$master);
$bot_settings = $result->fetchAll();
$bot_settings = $bot_settings[0];
$bot_settings['follow_cap_formatted'] = number_format($bot_settings['follow_cap']);
$result->free();

$smarty->assign('bot_settings',array_binary_yesno($bot_settings));


switch($url[1]) {
	case 'add':
		include('add.php');
		break;
}

if(isset($url[2])) {
	switch($url[2]) {
		case 'edit':
			include('edit.php');
			break;
		case 'userlists':
			include('userlists.php');
			break;
		case 'statistics':
			include('statistics.php');
			break;
		default:
			include('summary.php');
	}
}


/* This is a gross hack */
if($url[1]==trim(" ".(int)$url[1]." ") && !isset($url[2])) {
	include('summary.php');
}
?>