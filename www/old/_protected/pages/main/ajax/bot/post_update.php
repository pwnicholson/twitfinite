<?
if(strlen($_p['status'])>0) {
	$bot_info = get_group_info($bot_id);
	$_status = new Status(get_group_info($bot_info['group_id']));
	$ret = $_status->update($_p['status']);
	
	if($ret->error) {
		$err = $ret->error;
	} else {
		$insert = array(
			'group_id' => $bot_info['group_id'],
			'status_id' => $ret->id,
			'screen_name' => $ret->user->screen_name
		);
		$query = build_insert('tweets',$insert);
		q($query,$master);
		
		$msg = 'Status updated!';
	}
	
	$include = 'bot/post_update';
}
?>