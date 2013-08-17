<?
if($_p['twitter_screenname']) {
	$query = "SELECT twitter_screenname FROM group_inclusions WHERE group_id=".$bot_id." AND twitter_screenname='".$_p['twitter_screenname']."'";
	$result = q($query,$master);
	$include_users = $result->fetchAll();
	$result->free();
	
	if(count($include_users)==0) {
		$group_info = get_group_info($bot_id);
		$_u = new User($group_info);
		$show = $_u->show($_p['twitter_screenname']);
		
		$insert = array(
			'group_id' => $bot_id,
			'twitter_screenname' => $_p['twitter_screenname'],
			'twitter_user_id' => $show->id
		);
		$query = build_insert('group_inclusions',$insert);
		q($query,$master);
	}
}

if($_p['remove_screenname']) {
	$screennames = explode('|',$_p['remove_screenname']);
	
	$remove = array();
	foreach($screennames as $screenname) {
		if(strlen(trim($screenname))>0) $remove[] = $screenname;
	}
	
	$query = "DELETE FROM group_inclusions WHERE group_id=".$bot_id." AND twitter_screenname IN ('".implode("','",$remove)."')";
	q($query,$master);
}

$query = "SELECT twitter_screenname FROM group_inclusions WHERE group_id=".$bot_id." ORDER BY twitter_screenname";
$result = q($query,$master);
$include_users = $result->fetchAll();
$result->free();

$smarty->assign('include_users',$include_users);

$include = 'bot/include_users';
?>
