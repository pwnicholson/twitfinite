<?
/* Direct Messages */

function dms($row) {
	global $_a, $_s, $conn;
	
	if(check_rate($_a)) {
		/* New since_id stuff */
		$since_id = 0;
		$query = "SELECT status_id FROM tweets WHERE group_id=".$row['group_id']." AND incoming_type='dm' ORDER BY ts DESC LIMIT 1";
		$result = mysql_query($query,$conn);
		if(mysql_num_rows($result)>0) $since_id = mysql_result($result,0,'status_id');
		
		$_dm = new DirectMessage($row);
		$directmessages_xml = $_dm->direct_messages($since_id);
		if(@$directmessages_xml->error) {
			_log($row['twitter_screenname']." error: ".$replies_xml->error."\n");
		}
		
		$dms = array();
		foreach($directmessages_xml->direct_message as $dm) {
			$dms[strtotime($dm->created_at)] = $dm;
		}
		
		ksort($dms);
		
		foreach($dms as $status) {
			$query = "SELECT id FROM tweets WHERE group_id=".$row['group_id']." AND status_id='".addslashes($status->id)."' AND screen_name='".addslashes($status->sender->screen_name)."'";
			$result2 = mysql_query($query,$conn);
			if(mysql_num_rows($result2)==0) {
				if(isset($update)) unset($update);
				$update = trim($status->text);
				#$update = trim(preg_replace('/\@'.$row['twitter_screenname'].'/i','',$update,1));
				
				$status_id = $status->id;
				$twitter_user_id = $status->sender_id;
				$twitter_screenname = $status->sender->screen_name;
				
				$_c = new Console($row['group_id'],$twitter_user_id,$status_id,$update);
				
				if($retval = $_c->process_command()) {
					if($row['use_directmessages']==1) {
						$update = $retval;
						
						$orig_update = $update;
						if($row['show_names']==1) $update = username_format($row,$status->sender->screen_name).' '.$update;
						#if($row['show_names']==1) $update = $status->sender->screen_name.': '.$update;
					
						tweet_it($row, 'dm', $status_id, $twitter_user_id, $twitter_screenname, $update, $orig_update);
					}
				}
			}
		}
	
		unset($_dm);
	}
}
?>
