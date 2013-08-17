<?

/* MySQL Connection */
$conn = mysql_connect('localhost','retweetbot','jkALCT4H');
mysql_select_db('retweetbot',$conn);


require('API.php');

$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups WHERE id=29";
$result = mysql_query($query);
$rtb = mysql_fetch_assoc($result);

$_u = new User($rtb);

$query = "SELECT DISTINCT screen_name FROM tweets WHERE twitter_user_id IS NULL";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result)) {
	$show = $_u->show($row['screen_name']);
	if($show->id) {
		echo $row['screen_name'].' = '.$show->id."\n";
		$query = "UPDATE tweets SET twitter_user_id=".$show->id." WHERE screen_name='".$row['screen_name']."'";
		mysql_query($query);
	}
	
	sleep(2);
}

?>