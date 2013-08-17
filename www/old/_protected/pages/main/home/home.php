<?
#$feed_url = 'http://twitter.com/statuses/user_timeline/18454455.rss';
$feed_url = 'https://api.twitter.com/1/statuses/user_timeline.rss?screen_name=twitfinite';
$xml_str = file_get_contents($feed_url);

$xml = new SimpleXMLElement($xml_str);

$i = 0;
$updates = array();
foreach($xml->channel->item as $item) {
	if($i<10) {
		$text = $item->description;
		if(strtolower(substr($text,0,strlen('retweetbot: ')))=='retweetbot: ') {
			$len = strlen($text)-strlen('retweetbot: ');
			$text = substr($text,strlen('retweetbot: '),$len);
		}
		
		$text = autolink_url($text);
		$text = autolink_twitter($text);
		
		$ts = strtotime(trim($item->pubDate));
		
		$ts = calc_time_ago($ts);
		
		$updates[] = array(
			'text' => $text,
			'link' => trim($item->link),
			'ts' => $ts
		);
	}
	$i++;
}

$smarty->assign('updates',$updates);
?>
