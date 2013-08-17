<?
$query = "SELECT id FROM groups WHERE id='".$url[1]."' AND user_id=".$_s->get('user_id');
if($result = q($query,$master)) {
	$group = $result->fetchAll();
	$result->free();
	if(count($group)>0) {
		if($_p) {
			if($_p['delete']) {
				$query = "DELETE FROM groups WHERE id=".$url[1]." AND user_id=".$_s->get('user_id');
				q($query,$master);
				redirect('/');
			} else {
				$query = "UPDATE groups SET name='".$_p['name']."',twitter_email='".$_p['twitter_email']."',twitter_screenname='".$_p['twitter_screenname']."',twitter_password='".$_p['twitter_password']."',show_names=".intval($_p['show_names']).",use_replies=".intval($_p['use_replies']).",use_directmessages=".intval($_p['use_directmessages'])." WHERE id=".$url[1];
				q($query,$master);
				$msg[] = "Group updated!";
			}
		}
		
		$query = "SELECT * FROM groups WHERE id='".$url[1]."' AND user_id=".$_s->get('user_id');
		if($result = q($query,$master)) {
			$group = $result->fetchAll();
			$result->free();
			
			$group = $group[0];
			$smarty->assign('group',$group);
		}
	} else {
		if($_p) {
			$query = "SELECT id FROM groups WHERE user_id=".$_s->get('user_id')." AND name='".$_p['name']."'";
			if($result = q($query,$master)) {
				$group = $result->fetchAll();
				$result->free();
				if(count($group)>0) {
					$err[] = "A group by that name already exists!";
					$smarty->assign('group',$_p);
				} else {
					if(!$_p['show_names']) $_p['show_names'] = 0;
					$query = "INSERT INTO groups (user_id,name,twitter_email,twitter_screenname,twitter_password,show_names) VALUES (".$_s->get('user_id').",'".$_p['name']."','".$_p['twitter_email']."','".$_p['twitter_screenname']."','".$_p['twitter_password']."',".intval($_p['show_names']).")";
					q($query,$master);
					
					$group_id = 0;
					$query = "SELECT id FROM groups WHERE user_id=".$_s->get('user_id')." ORDER BY id DESC";
					if($result = q($query,$master)) {
						$group_id = $result->fetchAll();
						$result->free();
						$group_id = $group_id[0]['id'];
						redirect('/group/'.$group_id);
					}
				}
			}
		}
	}
}

$include = 'index';
?>
