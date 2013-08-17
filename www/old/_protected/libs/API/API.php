<?
class Twitter {
	private $curl = '/usr/bin/curl -s --connect-timeout 2 --max-time 10 --stderr /dev/null -H "Pragma: no-cache" -H "Cache-control: no-cache" --compress';
	#private $base_url = 'http://twitter.com/';
	private $base_url = 'http://api.twitter.com/1/';
	private $source = 'retweetbot';

	protected $var_arr;

	protected $template;

	function __construct($arr) {
		$this->var_arr = $arr;
	}

	protected function post($url,$file,$auth=FALSE,$arr=array(),$debug=FALSE) {
		$arr['source'] = $this->source;
		
		if(count($arr)>0) {
			$this->template = ' -d "'.$this->gen_getpost_template($arr).'"';
		}

		return $this->call($url,$file,$auth,FALSE,TRUE,$arr,$debug);
	}

	protected function get($url,$file,$auth=FALSE,$arr=array(),$debug=FALSE) {
		$arr['source'] = $this->source;
		
		if(count($arr)>0) {
			$file .= '?'.$this->gen_getpost_template($arr);
		}

		return $this->call($url,$file,$auth,TRUE,FALSE,$arr,$debug);
	}

	protected function call($url,$file,$auth=FALSE,$get=FALSE,$post=FALSE,$arr=array(),$debug=FALSE) {
		$this->template = $this->curl.' '.$this->template;

		if($auth) {
			$this->template .= ' -u %%twitter_screenname%%:%%twitter_password%%';
		}

		if(strlen(trim($url))>0) $url .= '/';

		$cmd = $this->template_replace($this->template.' '.$this->base_url.$url.$file);
		#echo "[CMD] ".$cmd."\n";

		exec($cmd,$output);

		$output = implode("\n",$output);

		$output = str_ireplace('<?xml version="1.0" encoding="UTF-8"?>','',$output);
		$output = '<?xml version="1.0" encoding="UTF-8"?> '.$output;

		$this->template = '';
		
		return new SimpleXMLElement($output);
	}

	private function gen_getpost_template($arr) {
		$template = '';
		$keys = array_keys($arr);
		for($a=0;$a<count($keys);$a++) {
			if(!$arr[$keys[$a]]) {
				unset($arr[$keys[$a]]);
			}
		}

		$keys = array_keys($arr);
		for($a=0;$a<count($keys);$a++) {
			if($arr[$keys[$a]]) {
				$template .= $keys[$a].'='.urlencode(trim($arr[$keys[$a]]));
				if($a<count($keys)-1) $template .= '&';
			}
		}

		return $template;
	}

	private function template_replace($template='') {
		$arr = $this->var_arr;
		$keys = array_keys($arr);

		for($a=0;$a<count($keys);$a++) {
			#$arr[$keys[$a]] = urlencode($arr[$keys[$a]]);
			if($keys[$a]=='twitter_password') {
				$tmp = '';
                                #$arr[$keys[$a]] = addslashes($arr[$keys[$a]]);
                                #$arr[$keys[$a]] = str_replace('`','\`',$arr[$keys[$a]]);
                                #$arr[$keys[$a]] = str_replace('$','\$',$arr[$keys[$a]]);
                                #$arr[$keys[$a]] = str_replace('&','\&',$arr[$keys[$a]]);
                                for($b=0;$b<strlen($arr[$keys[$a]]);$b++) $tmp .= "\\".$arr[$keys[$a]][$b];
                                $arr[$keys[$a]] = $tmp;
			}
			$template = str_replace('%%'.strtolower($keys[$a]).'%%',$arr[$keys[$a]],$template);
		}

		return $template;
	}

	private function debug() {

	}
}

class Status extends Twitter {
	private $url = "statuses";

	function public_timeline() {
		return parent::get($this->url,'public_timeline.xml');
	}

	function friends_timeline($since=FALSE,$since_id=FALSE,$count=FALSE,$page=FALSE) {
		$arr = array(
			'since' => $since,
			'since_id' => $since_id,
			'count' => $count,
			'page' => $page
		);

		return parent::get($this->url,'friends_timeline.xml',TRUE,$arr);
	}

	function user_timeline($id=FALSE,$since=FALSE,$since_id=FALSE,$count=FALSE,$page=FALSE) {
		$arr = array(
			'id' => $id,
			'since' => $since,
			'since_id' => $since_id,
			'count' => $count,
			'page' => $page
		);

		return parent::get($this->url,'user_timeline.xml',TRUE,$arr);
	}

	function show($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::get($this->url,'show.xml',FALSE,$arr);
	}

	function update($status=FALSE,$in_reply_to_status_id=FALSE) {
		$arr = array(
			'status' => $status,
			'in_reply_to_status_id' => $in_reply_to_status_id
		);

		return parent::post($this->url,'update.xml',TRUE,$arr);
	}

	function replies($page=FALSE,$since=FALSE,$since_id=FALSE) {
		$arr = array(
			'page' => $page,
			'since' => $since,
			'since_id' => $since_id
		);

		return parent::get($this->url,'replies.xml',TRUE,$arr);
	}

	function mentions($page=FALSE,$since_id=FALSE) {
		$arr = array(
			'page' => $page,
			'since_id' => $since_id
		);

		return parent::get($this->url,'mentions.xml',TRUE,$arr);
	}

	function destroy($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'destroy/'.$id.'.xml',TRUE,$arr);
	}
}

class User extends Twitter {
	private $url = "statuses";

	function friends($id=FALSE,$page=FALSE) {
		if($id) $arr['id'] = $id;
		if($page) {
			if(strtolower($page)=='all') {
				$friends = array();
				$keepgoing = TRUE;
				$page = 1;
				while($keepgoing) {
					$tmp = parent::get($this->url,'friends.xml',TRUE,array('page' => $page));
					$friends[] = $tmp;
					if(count($tmp[0])<100) $keepgoing = FALSE;
					$page++;
				}
				return $friends;
			} else {
				$arr['page'] = $page;
				return parent::get($this->url,'friends.xml',TRUE,$arr);
			}
		}
	}

	function followers($id=FALSE,$page=FALSE) {
		if($id) $arr['id'] = $id;
		if($page) {
			if(strtolower($page)=='all') {
				$followers = array();
				$keepgoing = TRUE;
				$page = 1;
				while($keepgoing) {
					$tmp = parent::get($this->url,'followers.xml',TRUE,array('page' => $page));
					$followers[] = $tmp;
					if(count($tmp[0])<100) $keepgoing = FALSE;
					$page++;
				}
				return $followers;
			} else {
				$arr['page'] = $page;
				return parent::get($this->url,'followers.xml',TRUE,$arr);
			}
		}
	}

	function show($id=FALSE,$email=FALSE) {
		if($id) $arr['id'] = $id;
		if($email) $arr['email'] = $email;

		return parent::get('users','show/'.$id.'.xml',TRUE,$arr);
	}
}

class DirectMessage extends Twitter {
	private $url = "";

	function direct_messages($since_id=FALSE,$page=FALSE) {
		if($page) {
			$arr = array();
			if($since_id) $arr['since_id'] = $since_id;
			
			if(strtolower($page)=='all') {
				$dms = array();
				$keepgoing = TRUE;
				$page = 1;
				while($keepgoing) {
					$arr['page'] = $page;
					$tmp = parent::get($this->url,'direct_messages.xml',TRUE,$arr);
					$dms[] = $tmp;
					if(count($tmp[0])<20) $keepgoing = FALSE;
					$page++;
				}
				return $dms;
			} else {
				$arr['page'] = $page;
				return parent::get($this->url,'direct_messages.xml',TRUE,$arr);
			}
		} else {
			$arr = array(
				'since_id' => $since_id,
				'page' => $page
			);
			return parent::get($this->url,'direct_messages.xml',TRUE,$arr);
		}
	}

	function sent($since_id=FALSE,$page=FALSE) {
		$arr = array(
			'since_id' => $since_id,
			'page' => $page
		);

		return parent::get($this->url,'direct_messages/sent.xml',TRUE,$arr);
	}

	function _new($user=FALSE,$text=FALSE) {
		$arr = array(
			'user' => $user,
			'text' => $text
		);

		return parent::post($this->url,'direct_messages/new.xml',TRUE,$arr);
	}

	function destroy($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'direct_messages/destroy/'.$id.'.xml',TRUE,$arr);
	}
}

class Friendship extends Twitter {
	private $url = "friendships";

	function create($id=FALSE,$follow=FALSE) {
		$arr = array(
			'id' => $id
		);

		if($follow) {
			$file = 'create/'.$id.'.xml?follow=true';
		} else {
			$file = 'create/'.$id.'.xml';
		}

		return parent::post($this->url,$file,TRUE,$arr);
	}

	function destroy($id) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'destroy/'.$id.'.xml',TRUE,$arr);
	}

	function exists($user_a=FALSE,$user_b=FALSE) {
		$arr = array(
			'user_a' => $user_a,
			'user_b' => $user_b
		);

		return parent::get($this->url,'exists.xml',TRUE,$arr);
	}
}

class Account extends Twitter {
	private $url = "account";

	function verify_credentials() {
		return parent::get($this->url,'verify_credentials.xml',TRUE);
	}

	function end_session() {
		$arr = array(
			'post' => 'post'
		);

		return parent::post($this->url,'end_session',TRUE);
	}

	function update_delivery_device($device=FALSE) {
		$arr = array(
			'device' => $device
		);

		return parent::post($this->url,'update_delivery_device.xml?device='.$device,TRUE,$arr);
	}

	function update_profile_colors($profile_background_color=FALSE,$profile_text_color=FALSE,$profile_link_color=FALSE,$profile_sidebar_fill_color=FALSE,$profile_sidebar_border_color=FALSE) {
		$arr = array(
			'profile_background_color' => $profile_background_color,
			'profile_text_color' => $profile_text_color,
			'profile_link_color' => $profile_link_color,
			'profile_sidebar_fill_color' => $profile_sidebar_fill_color,
			'profile_sidebar_border_color' => $profile_sidebar_border_color
		);

		return parent::post($this->url,'update_profile_colors.xml',TRUE,$arr);
	}

	function update_profile_image($image=FALSE) {
		/* Not yet supported */
	}

	function update_profile_background_image($image=FALSE) {
		/* Not yet supported */
	}

	function rate_limit_status() {
		return parent::get($this->url,'rate_limit_status.xml',TRUE);
	}

	function update_profile($name=FALSE,$email=FALSE,$url=FALSE,$location=FALSE,$description=FALSE) {
		$arr = array(
			'name' => $name,
			'email' => $email,
			'url' => $url,
			'location' => $location,
			'description' => $description
		);

		return parent::post($this->url,'update_profile.xml',TRUE,$arr);
	}
}

class Favorite extends Twitter {
	private $url = "";

	function favorites($id=FALSE,$page=FALSE) {
		$arr = array(
			'id' => $id,
			'page' => $page
		);

		return parent::get($this->url,'favorites.xml',TRUE,$arr);
	}

	function create($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'favorites/create/'.$id.'.xml',TRUE,$arr);
	}

	function destroy($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'favorites/destroy/'.$id.'.xml',TRUE,$arr);
	}
}

class Notification extends Twitter {
	private $url = "notifications";

	function follow($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'follow/'.$id.'.xml',TRUE,$arr);
	}

	function leave($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'leave/'.$id.'.xml',TRUE,$arr);
	}
}

class Block extends Twitter {
	private $url = "blocks";

	function create($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'create/'.$id.'.xml',TRUE,$arr);
	}

	function destroy($id=FALSE) {
		$arr = array(
			'id' => $id
		);

		return parent::post($this->url,'destroy/'.$id.'.xml',TRUE,$arr);
	}
}

class SocialGraph extends Twitter {
	private $url = "";
	
	function friends($id=FALSE) {
		$arr = array(
			'id' => $id
		);
		
		return parent::post($this->url,'friends/ids/'.$id.'.xml',TRUE,$arr);
	}
	
	function followers($id=FALSE) {
		$arr = array(
			'id' => $id
		);
		
		return parent::post($this->url,'followers/ids/'.$id.'.xml',TRUE,$arr);
	}
}

class Help extends Twitter {
	private $url = "help";

	function test() {
		return parent::call($this->url,'test.xml');
	}

	function downtime_schedule() {
		return parent::call($this->url,'downtime_schedule.xml');
	}
}
?>
