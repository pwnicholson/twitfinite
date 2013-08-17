<?
if($_p) {
	$query = "SELECT id,admin FROM users WHERE username='".$_p['username']."' AND password=PASSWORD('".$_p['password']."')";
	if($result = q($query,$master)) {
		$user = $result->fetchAll();
			if(count($user)==1) {
				$result->free();
				$_s->set('user_id',$user[0]['id']);
				$_s->set('admin',$user[0]['admin']);
				redirect('retweet');
			} else {
				$err['fail'] = "Invalid username or password.";
			}
		}
}

$onload = "$('username').focus()";
?>