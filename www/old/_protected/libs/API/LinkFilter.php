<?
function filter_link($group,$status) {
	$regex = '/^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/';
	$regex = '/((https?|ftp|gopher|telnet|file|notes|ms-help):((\/\/)|(\\\\))+[\w\d:#@%/\;$()~_?\+-=\\\.&]*)/';
	$regex = '(((file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp)://)|(www\.))+(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(/[a-zA-Z0-9\&amp;%_\./-~-]*)?';
	#echo $regex;
	eregi($regex,$status,$matches);
	
	if($matches) {
		switch($group['link_filter']) {
			case 'b':  # Block entire post
				return FALSE;
				break;
			case 'd':  # Delete link
				return eregi_replace($regex,'',$status);
				break;
			default:
				return $status;
		}
	} else {
		return $status;
	}
}
?>