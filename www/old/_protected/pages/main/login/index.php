<?
$onload = "$('username').focus()";

if($_p) {
	$query = "SELECT id FROM users WHERE username='".$_p['username']."' AND password=PASSWORD('".$_p['password']."')";
	if($result = q($query,$master)) {
		$user = $result->fetchAll();
		if(count($user)==1) {
			$result->free();
			$_s->set('user_id',$user[0]['id']);
			redirect('home');
		} else {
			$err[] = "Invalid username or password.";
		}
	}
}

$include = 'index';
?>
