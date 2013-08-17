<?
function check_new_bot($row) {
	global $conn;
	
	$query = "SELECT COUNT(id) AS num FROM tweets WHERE group_id=".$row['group_id'];
	$result = mysql_query($query,$conn);
	$row2 = mysql_fetch_assoc($result);
	
	/* See if this is the first tweet */
	if($row2['num']==0) {
		/* This will announce the new bot */
		$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups WHERE id=29";
		$result = mysql_query($query);
		$rtb = mysql_fetch_assoc($result);

		
		if($row['list_in_directory']==1) {
			$_s = new Status($rtb);
			$_s->update('New conversation started over at @'.$row['twitter_screenname'].'!');
			_log("ReTweetBot: announce ".$row['twitter_screenname']." (".$_s->id.")",'n');
			unset($_s);
		}
		
		
		/* This will force @retweetbot to follow the new bot */
		$_f = new Friendship($rtb);
		$_f->create($row['twitter_screenname']);
		_log($rtb['twitter_screenname'].": follow bot ".$row['twitter_screenname'],'n');
		unset($_f);
		
		/* Force the new bot to follow @retweetbot */
		$_f = new Friendship($row);
		$_f->create($rtb['twitter_screenname']);
		_log($row['twitter_screenname'].": follow bot ".$rtb['twitter_screenname'],'n');
		unset($_f);
	}
}
?>