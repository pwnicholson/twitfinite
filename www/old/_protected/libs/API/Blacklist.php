<?
function blacklist_check($group_id=0,$twitter_user_id=0) {
	global $conn;
	
	$query = "SELECT * FROM group_blacklist WHERE group_id=".$group_id." AND twitter_user_id=".$twitter_user_id;
	$result = mysql_query($query,$conn);
	if(mysql_num_rows($result)>0) {
		return FALSE;
	} else {
		return TRUE;
	}
}
?>