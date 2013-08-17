<?
if(!$_s->get('user_id')) {
	redirect('/home/login');
}

if(!$_s->get('admin')==1) {
	redirect('/retweet');
}

switch($url[1]) {
	case 'movebot':
		require('movebot.php');
		break;
	case 'createaccount':
		require('createaccount.php');
		break;
	case 'listusers':
		require('listusers.php');
		break;
	case 'massmail':
		require('massmail.php');
		break;
	default:
		$title = 'Admin';
		$include = 'index';
}
?>