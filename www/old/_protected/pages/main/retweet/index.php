<?
if(!$_s->get('user_id')) {
	redirect('/home/login');
}

$user_id = $_s->get('user_id');

switch($url[1]) {
	case 'account':
		require('account.php');
		break;
	default:
		require('bots.php');
}
?>
