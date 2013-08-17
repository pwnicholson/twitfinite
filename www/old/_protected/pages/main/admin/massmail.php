<?
if($_p) {
	if(strlen(trim($_p['from_name']))==0) $err['from_name'] = 'You must enter a from name';
	if(strlen(trim($_p['from_address']))==0) $err['from_address'] = 'You must enter a from address';
	if(strlen(trim($_p['subject']))==0) $err['subject'] = 'You must enter a subject';
	if(strlen(trim($_p['message']))==0) $err['message'] = 'You must enter a body';
	
	if(!isset($err)) {
		$subject = $_p['subject'];
		$headers = 'From: '.$_p['from_name'].' <'.$_p['from_address'].'>';
		$message = $_p['message'];
		
		switch($_p['to']) {
			case 'subscribers':
				$query = "SELECT DISTINCT email,firstname,lastname FROM users WHERE newsletter=1";
				$message .= "\n\nThis message was sent to you because you are signed up to receive messages from http://www.retweetbot.com.  If you wish to be removed, please log in to your account and uncheck the \"Get E-mail Updates\" box.";
				break;
			case 'all':
				$query = "SELECT DISTINCT email,firstname,lastname FROM users";
				$message .= "\n\nThis message was sent to you because the administrators of http://www.retweetbot.com deemed this message of utmost importance and MUST be sent to you.  If you have any complaints, please go to http://www.retweetbot.com/home/contactus and file a complaint.";
				break;
			default:	# admin
				$query = "SELECT DISTINCT email,firstname,lastname FROM users WHERE admin=1";
				$message .= "\n\nThis message was sent to you because you are an admin at http://www.retweetbot.com and you have no choice but to receive this message.";
		}
		$result = q($query,$master);
		$row = $result->fetchAll();
		
		$message = wordwrap($message,70);
		
		foreach($row as $email) {
			$to = $email['firstname'].' '.$email['lastname'].' <'.$email['email'].'>';
			@mail($to,$subject,$message,$headers);
		}
		
		$msg[] = "Mass mail sent!";
	}
}

$title = 'Send Mass E-mail';

$include = 'massmail';
?>
