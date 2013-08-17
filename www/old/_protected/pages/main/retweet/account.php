<?
if((int)$url[2]>0 && $_s->get('admin')==1) {
	$user_id = (int)$url[2];
}

if($_p) {
	if(!$_p['firstname']) $err['firstname'] = "Please enter your first name.";
	if(!$_p['lastname']) $err['lastname'] = "Please enter your last name.";
	if(!$_p['email']) $err['email'] = "Please enter your e-mail address.";
	
	if($_p['newsletter']=='Y') {
		$_p['newsletter'] = 1;
	} else {
		$_p['newsletter'] = 0;
	}
	
	if($_p['admin']=='Y' && $_s->get('admin')==1) {
		$_p['admin'] = 1;
	} else {
		$_p['admin'] = 0;
	}
	
	if(!$err) {
		$query = "SELECT firstname,lastname,email FROM users WHERE id=".$user_id;
		$result = q($query,$master);
		$user = $result->fetchAll();
		$result->free();
		
		#$user_existing = $user[0]['firstname'].$user[0]['lastname'].$user[0]['email'];
		#$user_post = $_p['firstname'].$_p['lastname'].$_p['email'];
		
		#if($user_existing!=$user_post) {
			$query = <<<EOQ
UPDATE
	users
SET
	firstname='{$_p['firstname']}',
	lastname='{$_p['lastname']}',
	email='{$_p['email']}',
	admin={$_p['admin']},
	newsletter={$_p['newsletter']}
WHERE
	id={$user_id}
EOQ;
			q($query,$master);
			$msg['account'] = "Account information updated!";
		#}
	}
	
	if($_p['password1'] && $_p['password2']) {
		if($_p['password1']!=$_p['password2']) {
			$err['password'] = "The passwords do not match.";
		} else {
			$query = <<<EOQ
UPDATE
	users
SET
	password=PASSWORD('{$_p['password1']}')
WHERE
	id={$user_id}
EOQ;
			q($query,$master);
			$msg['password'] = "Password updated!";
		}
	}
}

$query = "SELECT * FROM users WHERE id=".$user_id;
$result = q($query,$master);
$user = $result->fetchAll();
$result->free();

$smarty->assign('user',$user[0]);

$title = 'My Account';

$include = 'account';
?>