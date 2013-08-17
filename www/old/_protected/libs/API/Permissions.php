<?
function check_permissions($group_id,$twitter_user_id) {
	global $conn;
	
	$query = "SELECT retweet_restrictions FROM groups WHERE id=".$group_id;
	$result = mysql_query($query,$conn);
	$retweet_restrictions = mysql_result($result,0,'retweet_restrictions');
	
	switch($retweet_restrictions) {
		case 'a':
			return check_admins($group_id,$twitter_user_id);
			break;
		case 'i':
			return check_inclusions($group_id,$twitter_user_id);
			break;
		default:
			return TRUE;
	}
}

function check_admins($group_id,$twitter_user_id) {
	global $conn;
	
	$retval = FALSE;
	
	$query = "SELECT id FROM group_admins WHERE group_id=".$group_id." AND twitter_user_id='".$twitter_user_id."'";
	$result = mysql_query($query,$conn);
	if(mysql_num_rows($result)>0) {
		$retval = TRUE;
	} else {
		$retval = FALSE;
	}
	
	return $retval;
}

function check_inclusions($group_id,$twitter_user_id) {
	global $conn;

	$retval = check_admins($group_id,$twitter_user_id);
	
	if(!$retval) {
		$query = "SELECT id FROM group_inclusions WHERE group_id=".$group_id." AND twitter_user_id='".$twitter_user_id."'";
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)>0) {
			$retval = TRUE;
		} else {
			$retval = FALSE;
		}
	}
	
	return $retval;
}
?>