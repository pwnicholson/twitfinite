<?
if($_p['blacklist']) {
	$query = "SELECT twitter_screenname FROM group_blacklist WHERE group_id=".$bot_id." AND twitter_screenname='".$_p['blacklist']."'";
	$result = q($query,$master);
	$blacklist = $result->fetchAll();
	$result->free();
	
	if(count($blacklist)==0) {
		$group_info = get_group_info($bot_id);
		$_u = new User($group_info);
		$show = $_u->show($_p['blacklist']);
		
		$_f = new Friendship($group_info);
		$_f->destroy($show->id);
		
		$insert = array(
			'group_id' => $bot_id,
			'twitter_screenname' => $_p['blacklist'],
			'twitter_user_id' => $show->id
		);
		$query = build_insert('group_blacklist',$insert);
		q($query,$master);
	}
}

if($_p['remove_blacklist']) {
	$screennames = explode('|',$_p['remove_blacklist']);
	
	$remove = array();
	foreach($screennames as $screenname) {
		if(strlen(trim($screenname))>0) $remove[] = $screenname;
	}
	
	$query = "DELETE FROM group_blacklist WHERE group_id=".$bot_id." AND twitter_screenname IN ('".implode("','",$remove)."')";
	q($query,$master);
}

$query = "SELECT twitter_screenname FROM group_blacklist WHERE group_id=".$bot_id." ORDER BY twitter_screenname";
$result = q($query,$master);
$blacklist = $result->fetchAll();
$result->free();

$smarty->assign('blacklist',$blacklist);

$include = 'bot/blacklist';
?>