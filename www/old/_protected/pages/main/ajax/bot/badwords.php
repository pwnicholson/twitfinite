<?
if($_p['badword']) {
	$query = "SELECT badword FROM group_badwords WHERE group_id=".$bot_id." AND badword='".$_p['badword']."'";
	$result = q($query,$master);
	$badwords = $result->fetchAll();
	$result->free();
	
	if(count($badwords)==0) {
		$insert = array(
			'group_id' => $bot_id,
			'badword' => $_p['badword']
		);
		$query = build_insert('group_badwords',$insert);
		q($query,$master);
	}
}

if($_p['remove_badword']) {
	$badwords = explode('|||||',$_p['remove_badword']);
	
	$remove = array();
	foreach($badwords as $badword) {
		if(strlen(trim($badword))>0) $remove[] = $badword;
	}
	
	$query = "DELETE FROM group_badwords WHERE group_id=".$bot_id." AND badword IN ('".implode("','",$remove)."')";
	q($query,$master);
}

$query = "SELECT badword FROM group_badwords WHERE group_id=".$bot_id." ORDER BY badword";
$result = q($query,$master);
$badwords = $result->fetchAll();
$result->free();

$smarty->assign('badwords',$badwords);

$include = 'bot/badwords';
?>