<?
/* Replies */
function replies($row) {
	global $_a, $_s, $conn;
	
	if(check_rate($_a)) {
		/* New since_id stuff */
		$since_id = 0;
		$query = "SELECT status_id FROM tweets WHERE group_id=".$row['group_id']." AND incoming_type='reply' ORDER BY ts DESC LIMIT 1";
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)>0) $since_id = mysql_result($result,0,'status_id');
		
		$replies_xml = $_s->mentions(FALSE,$since_id);
		if(@$replies_xml->error) {
			_log($row['twitter_screenname']." error: ".$replies_xml->error."\n");
		}
		
		$replies = array();
		foreach($replies_xml->status as $reply) {
			if(strtoupper($reply->user->screen_name) != strtoupper($row['twitter_screenname']))
				$replies[strtotime($reply->created_at)] = $reply;
		}

		ksort($replies);
		
		foreach($replies as $status) {
			$query = "SELECT id FROM tweets WHERE group_id=".$row['group_id']." AND status_id='".addslashes($status->id)."' AND screen_name='".addslashes($status->user->screen_name)."'";
			$result2 = mysql_query($query);
			if(mysql_num_rows($result2)==0) {
				if(isset($update)) unset($update);
				$update = trim($status->text);
				
				/* This should limit @replies to only replies that begin with the bot's name */
				if(stripos($update,'@'.$row['twitter_screenname'])==0) {
					#$update = trim(preg_replace('/\@'.$row['twitter_screenname'].'/i','',$update,1));
					$update = trim(substr($update, (strlen('@'.$row['twitter_screenname'])), (strlen($update)-1) ));
					
					$status_id = $status->id;
					$twitter_user_id = $status->user->id;
					$twitter_screenname = $status->user->screen_name;
					
					$_c = new Console($row['group_id'],$twitter_user_id,$status_id,$update);
		
					if($retval = $_c->process_command()) {
						if($row['use_replies']==1) {
							$update = $retval;
							
							$orig_update = $update;
							if($row['show_names']==1) $update = username_format($row,$status->user->screen_name).' '.$update;
							
							tweet_it($row, 'reply', $status_id, $twitter_user_id, $twitter_screenname, $update, $orig_update);
						}
					}
				} else {
					#@_log($row['twitter_screenname'].": Ignored @reply because it did not start with the screen name. (".stripos($update,'@'.$row['twitter_screenname']).")");
				}
			}
		}
	}
}
?>
