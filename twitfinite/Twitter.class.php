<?
class Twitter {
	public $debug;
	private $consumer_token, $consumer_secret;
	private $oauth_token, $oauth_secret;

	function __construct($consumer_token, $consumer_secret, $oauth_token, $oauth_secret) {
		$this->debug = FALSE;

		$this->consumer_token = $consumer_token;
		$this->consumer_secret = $consumer_secret;
		$this->oauth_token = $oauth_token;
		$this->oauth_secret = $oauth_secret;
	}


	function __destruct() {
		
	}


	private function error($msg, $fatal=TRUE) {
		if(!is_array($msg))
			echo 'ERROR: '.$msg."\n";
		else
			foreach($msg as $m)
				echo 'ERROR: '.$m."\n";

		if($fatal)
			exit;
	}


	private function call($request_type='GET', $auth=FALSE, $url='', $params=array()) {
		$TwitterOAuth = new TwitterOAuth($this->consumer_token,$this->consumer_secret,$this->oauth_token,$this->oauth_secret);

		/* Remove empty params */
		foreach($params as $p_k => $p_v)
			if(strlen(trim($p_v))==0)
				unset($params[$p_k]);

		switch(strtoupper($request_type)) {
			case 'POST':
				$retval = $TwitterOAuth->post($url, $params);
				break;
			default:
				$retval = $TwitterOAuth->get($url, $params);
		}


		/* Return */
		return $retval;
	}


	/* statuses/public_timeline - http://dev.twitter.com/doc/get/statuses/public_timeline */
	public function statuses_public_timeline() {
		$retval = $this->call('GET', FALSE, 'statuses/public_timeline');
		return $retval;
	}


	/* statuses/home_timeline - http://dev.twitter.com/doc/get/statuses/home_timeline */
	public function statuses_home_timeline($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/home_timeline', $params);
		return $retval;
	}


	/* statuses/friends_timeline - http://dev.twitter.com/doc/get/statuses/friends_timeline */
	public function statuses_friends_timeline($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/friends_timeline', $params);
		return $retval;
	}


	/* statuses/user_timeline - http://dev.twitter.com/doc/get/statuses/user_timeline */
	public function statuses_user_timeline($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;
		
		$retval = $this->call('GET', TRUE, 'statuses/user_timeline', $params);
		return $retval;
	}


	/* statuses/mentions - http://dev.twitter.com/doc/get/statuses/mentions */
	public function statuses_mentions($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/mentions', $params);
		return $retval;
	}


	/* statuses/retweeted_by_me - http://dev.twitter.com/doc/get/statuses/retweeted_by_me */
	public function statuses_retweeted_by_me($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;
		
		$retval = $this->call('GET', TRUE, 'statuses/retweeted_by_me', $params);
		return $retval;
	}


	/* statuses/retweeted_to_me - http://dev.twitter.com/doc/get/statuses/retweeted_to_me */
	public function statuses_retweeted_to_me($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;
		
		$retval = $this->call('GET', TRUE, 'statuses/retweeted_to_me', $params);
		return $retval;
	}


	/* statuses/retweets_of_me - http://dev.twitter.com/doc/get/statuses/retweets_of_me */
	public function statuses_retweets_of_me($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/retweets_of_me', $params);
		return $retval;
	}


	/* statuses/show - http://dev.twitter.com/doc/get/statuses/show */
	public function statuses_show($id=0) {
		$retval = $this->call('GET', FALSE, 'statuses/show', array('id'=>$id));
		return $retval;
	}


	/* statuses/update - http://dev.twitter.com/doc/post/statuses/update */
	public function statuses_update($status='', $in_reply_to_status_id=FALSE, $lat=FALSE, $lon=FALSE, $place_id=FALSE, $display_coordinates=FALSE) {
		$params = array();

		$params['status'] = $status;
		if($in_reply_to_status_id!==FALSE) $params['in_reply_to_status_id'] = $in_reply_to_status_id;
		if($lat!==FALSE) $params['lat'] = $lat;
		if($lon!==FALSE) $params['lon'] = $lon;
		if($place_id!==FALSE) $params['place_id'] = $place_id;
		if($display_coordinates!==FALSE) $params['display_coordinates'] = $display_coordinates;

		$retval = $this->call('POST', TRUE, 'statuses/update', $params);
		return $retval;
	}


	/* statuses/destroy - http://dev.twitter.com/doc/post/statuses/destroy */
	public function statuses_destroy($id=0) {
		$params = array();

		$params['id'] = $id;

		$retval = $this->call('POST', TRUE, 'statuses/destroy', $params);
		return $retval;
	}


	/* statuses/retweet - http://dev.twitter.com/doc/post/statuses/retweet */
	public function statuses_retweet($id=0) {
		$params = array();

		$params['id'] = $id;

		$retval = $this->call('POST', FALSE, 'statuses/retweet', $params);
		return $retval;
	}


	/* statuses/retweets - http://dev.twitter.com/doc/get/statuses/retweets */
	public function statuses_retweets($id=0, $count=FALSE) {
		$params = array();

		$params['id'] = $id;
		if($count!==FALSE) $params['count'] = $count;

		$retval = $this->call('GET', FALSE, 'statuses/retweets', $params);
		return $retval;
	}


	/* statuses/id/retweeted_by - http://dev.twitter.com/doc/get/statuses/id/retweeted_by */
	public function statuses_id_retweeted_by($id=0, $count=FALSE, $page=FALSE) {
		$params = array();

		$params['id'] = $id;

		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/id/retweeted_by', $params);
		return $retval;
	}


	/* statuses/id/retweeted_by/ids - http://dev.twitter.com/doc/get/statuses/id/retweeted_by/ids */
	public function statuses_id_retweeted_by_ids($id=0, $count=FALSE, $page=FALSE) {
		$params = array();

		$params['id'] = $id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'statuses/id/retweeted_by/ids', $params);
		return $retval;
	}


	/* users/show - http://dev.twitter.com/doc/get/users/show */
	public function users_show($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $scree_name;

		$retval = $this->call('GET', FALSE, 'users/show', $params);
		return $retval;
	}


	/* users/lookup - http://dev.twitter.com/doc/get/users/lookup */
	public function users_lookup($user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('GET', TRUE, 'users/lookup', $params);
		return $retval;
	}


	/* users/search - http://dev.twitter.com/doc/get/users/search */
	public function users_search($q='', $per_page=FALSE, $page=FALSE) {
		$params = array();

		$params['q'] = $q;
		if($per_page!==FALSE) $params['per_page'] = $per_page;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'users/search', $params);
		return $retval;
	}


	/* users/suggestions - http://dev.twitter.com/doc/get/users/suggestions */
	public function users_suggestions() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'users/suggestions', $params);
		return $retval;
	}


	/* users/suggestions/slug - http://dev.twitter.com/doc/get/users/suggestions/slug */
	public function users_suggestions_slug($slug='') {
		$params = array();

		$params['slug'] = $slug;

		$retval = $this->call('GET', FALSE, 'users/suggestions/slug', $params);
		return $retval;
	}


	/* statuses/friends - http://dev.twitter.com/doc/get/statuses/friends */
	public function statuses_friends($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $cursor=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', FALSE, 'statuses/friends', $params);
	}


	/* statuses/followers - http://dev.twitter.com/doc/get/statuses/followers */
	public function statuses_followers($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $cursor=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $scree_name;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', FALSE, 'statuses/followers', $params);
		return $retval;
	}


	/* trends - http://dev.twitter.com/doc/get/trends */
	public function trends() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'trends', $params);
		return $retval;
	}


	/* trends/current - http://dev.twitter.com/doc/get/trends/current */
	public function trends_current($exclude=FALSE) {
		$params = array();

		if($exclude!==FALSE) $params['exclude'] = $exclude;

		$retval = $this->call('GET', FALSE, 'trends/current', $params);
		return $retval;
	}


	/* trends/daily - http://dev.twitter.com/doc/get/trends/daily */
	public function trends_daily($exclude=FALSE, $date=FALSE) {
		$params = array();

		if($exclude!==FALSE) $params['exclude'] = $exclude;
		if($date!==FALSE) $params['date'] = $date;

		$retval = $this->call('GET', FALSE, 'trends/daily', $params);
		return $retval;
	}


	/* trends/weekly - http://dev.twitter.com/doc/get/trends/weekly */
	public function trends_weekly($exclude=FALSE, $date=FALSE) {
		$params = array();

		if($exclude!==FALSE) $params['exclude'] = $exclude;
		if($date!==FALSE) $params['date'] = $date;

		$retval = $this->call('GET', FALSE, 'trends/weekly', $params);
		return $retval;
	}


	/* :user/lists - http://dev.twitter.com/doc/post/:user/lists */
	public function user_lists($cursor=FALSE) {
		$params = array();

		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('POST', TRUE, ':user/lists', $params);
		return $retval;
	}


	/* :user/lists/:id - http://dev.twitter.com/doc/post/:user/lists/:id */
	public function user_lists_id($name=FALSE, $mode=FALSE, $description=FALSE) {
		$params = array();

		if($name!==FALSE) $params['name'] = $name;
		if($mode!==FALSE) $params['mode'] = $mode;
		if($description!==FALSE) $params['description'] = $description;

		$retval = $this->call('POST', TRUE, ':user/lists/:id', $params);
		return $retval;
	}


	/* :user/lists/:id/statuses - http://dev.twitter.com/doc/get/:user/lists/:id/statuses */
	public function user_lists_id_statuses($since_id=FALSE, $max_id=FALSE, $per_page=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($per_page!==FALSE) $params['per_page'] = $per_page;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', FALSE, ':user/lists/:id/statuses', $params);
		return $retval;
	}


	/* :user/lists/memberships - http://dev.twitter.com/doc/get/:user/lists/memberships */
	public function user_lists_memberships($cursor=FALSE) {
		$params = array();

		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, ':user/lists/memberships', $params);
		return $retval;
	}


	/* :user/lists/subscriptions - http://dev.twitter.com/doc/get/:user/lists/subscriptions */
	public function user_lists_subscriptions($cursor=FALSE) {
		$params = array();

		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, ':user/lists/subscriptions', $params);
		return $retval;
	}


	/* :user/:list_id/members - http://dev.twitter.com/doc/get/:user/:list_id/members */
	public function user_list_id_members($id=FALSE, $cursor=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, ':user/:list_id/members', $params);
	}


	/* :user/:id/members - http://dev.twitter.com/doc/delete/:user/:id/members */
	public function user_id_members($id=0, $user_id=0) {
		$params = array();

		$params['id'] = $id;
		$params['user_id'] = $user_id;

		$retval = $this->call('DELETE', TRUE, ':user/:id/members', $params);
		return $retval;
	}


	/* :user/:list_id/members/:id - http://dev.twitter.com/doc/get/:user/:list_id/members/:id */
	public function user_list_id_members_id($id=0, $user_id=0) {
		$params = array();

		$params['id'] = $id;
		$params['user_id'] = $user_id;

		$retval = $this->call('GET', TRUE, ':user/:list_id/members/:id', $params);
		return $retval;
	}


	/* :user/:list_id/subscribers - http://dev.twitter.com/doc/get/:user/:list_id/subscribers */
	public function user_list_id_subscribers($id=0, $cursor=FALSE) {
		$params = array();

		$params['id'] = $id;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, ':user/:list_id/subscribers', $params);
		return $retval;
	}


	/* :user/:id/subscribers - http://dev.twitter.com/doc/delete/:user/:id/subscribers */
	public function user_id_subscribers($id=0, $user_id=0) {
		$params = array();

		$params['id'] = $id;
		$params['user_id'] = $user_id;

		$retval = $this->call('DELETE', TRUE, ':user/:id/subscribers', $params);
		return $retval;
	}


	/* :user/:list_id/subscribers/:id - http://dev.twitter.com/doc/get/:user/:list_id/subscribers/:id */
	public function user_list_id_subscribers_id($id=0, $user_id=0) {
		$params = array();

		$params['id'] = $id;
		$params['user_id'] = $user_id;

		$retval = $this->call('GET', TRUE, ':user/:list_id/subscribers/:id', $params);
		return $retval;
	}


	/* direct_messages - http://dev.twitter.com/doc/get/direct_messages */
	public function direct_messages($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', FALSE, 'direct_messages', $params);
		return $retval;
	}


	/* direct_messages/sent - http://dev.twitter.com/doc/get/direct_messages/sent */
	public function direct_messages_sent($since_id=FALSE, $max_id=FALSE, $count=FALSE, $page=FALSE) {
		$params = array();

		if($since_id!==FALSE) $params['since_id'] = $since_id;
		if($max_id!==FALSE) $params['max_id'] = $max_id;
		if($count!==FALSE) $params['count'] = $count;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', FALSE, 'direct_messages/sent', $params);
		return $retval;
	}


	/* direct_messages/new - http://dev.twitter.com/doc/post/direct_messages/new */
	public function direct_messages_new($text='', $user=FALSE, $screen_name=FALSE, $user_id=FALSE) {
		$params = array();

		$params['text'] = $text;
		if($user!==FALSE) $params['user'] = $user;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($user_id!==FALSE) $params['user_id'] = $user_id;

		$retval = $this->call('POST', TRUE, 'direct_messages/new', $params);
		return $retval;
	}


	/* direct_messages/destroy - http://dev.twitter.com/doc/post/direct_messages/destroy */
	public function direct_messages_destroy($id=0) {
		$params = array();

		$params['id'] = $id;

		$retval = $this->call('POST', TRUE, 'direct_messages/destroy', $params);
		return $retval;
	}


	/* friendships/create - http://dev.twitter.com/doc/post/friendships/create */
	public function friendships_create($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $follow=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($follow!==FALSE) $params['follow'] = $follow;

		$retval = $this->call('POST', TRUE, 'friendships/create', $params);
		return $retval;
	}


	/* friendships/destroy - http://dev.twitter.com/doc/post/friendships/destroy */
	public function friendships_destroy($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'friendships/destroy', $params);
		return $retval;
	}


	/* friendships/exists - http://dev.twitter.com/doc/get/friendships/exists */
	public function friendships_exists($user_a='', $user_b='') {
		$params = array();

		$params['user_a'] = $user_a;
		$params['user_b'] = $user_b;

		$retval = $this->call('GET', FALSE, 'friendships/exists', $params);
		return $retval;
	}


	/* friendships/show - http://dev.twitter.com/doc/get/friendships/show */
	public function friendships_show($source_id=FALSE, $source_screen_name=FALSE, $target_id=FALSE, $target_screen_name=FALSE) {
		$params = array();

		if($source_id!==FALSE) $params['source_id'] = $source_id;
		if($source_screen_name!==FALSE) $params['source_screen_name'] = $source_screen_name;
		if($target_id!==FALSE) $params['target_id'] = $target_id;
		if($target_screen_name!==FALSE) $params['target_screen_name'] = $target_screen_name;

		$retval = $this->call('GET', FALSE, 'friendships/show', $params);
		return $retval;
	}


	/* friendships/incoming - http://dev.twitter.com/doc/get/friendships/incoming */
	public function friendships_incoming($cursor='') {
		$params = array();

		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, 'friendships/incoming', $params);
		return $retval;
	}


	/* friendships/outgoing - http://dev.twitter.com/doc/get/friendships/outgoing */
	public function friendships_outgoing($cursor=FALSE) {
		$params = array();

		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', TRUE, 'friendships/outgoing', $params);
		return $retval;
	}


	/* friends/ids - http://dev.twitter.com/doc/get/friends/ids */
	public function friends_ids($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $cursor=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', FALSE, 'friends/ids', $params);
		return $retval;
	}


	/* followers/ids - http://dev.twitter.com/doc/get/followers/ids */
	public function followers_ids($id=FALSE, $user_id=FALSE, $screen_name=FALSE, $cursor=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;
		if($cursor!==FALSE) $params['cursor'] = $cursor;

		$retval = $this->call('GET', FALSE, 'followers/ids', $params);
		return $retval;
	}


	/* account/verify_credentials - http://dev.twitter.com/doc/get/account/verify_credentials */
	public function account_verify_credentials() {
		$params = array();

		$retval = $this->call('GET', TRUE, 'account/verify_credentials', $params);
		return $retval;
	}


	/* account/rate_limit_status - http://dev.twitter.com/doc/get/account/rate_limit_status */
	public function account_rate_limit_status() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'account/rate_limit_status', $params);
		return $retval;
	}


	/* account/end_session - http://dev.twitter.com/doc/post/account/end_session */
	public function account_end_session() {
		$params = array();

		$retval = $this->call('POST', TRUE, 'account/end_session', $params);
		return $retval;
	}


	/* account/update_delivery_device - http://dev.twitter.com/doc/post/account/update_delivery_device */
	public function account_update_delivery_device($device='') {
		$params = array();

		$params['device'] = $device;

		$retval = $this->call('POST', TRUE, 'account/ipdate_delivery_device', $params);
		return $retval;
	}


	/* account/update_profile_colors - http://dev.twitter.com/doc/post/account/update_profile_colors */
	public function account_update_profile_colors($profile_background_color=FALSE, $profile_text_color=FALSE, $profile_link_color=FALSE, $profile_sidebar_fill_color=FALSE, $profile_sidebar_border_color=FALSE) {
		$params = array();

		if($profile_background_color!==FALSE) $params['profile_background_color'] = $profile_background_color;
		if($profile_text_color!==FALSE) $params['profile_text_color'] = $profile_text_color;
		if($profile_link_color!==FALSE) $params['profile_link_color'] = $profile_link_color;
		if($profile_sidebar_fill_color!==FALSE) $params['profile_sidebar_fill_color'] = $profile_sidebar_fill_color;
		if($profile_sidebar_border_color!==FALSE) $params['profile_sidebar_border_color'] = $profile_sidebar_border_color;

		$retval = $this->call('POST', TRUE, 'account/update_profile_colors', $params);
		return $retval;
	}


	/* account/update_profile_image - http://dev.twitter.com/doc/post/account/update_profile_image */
	public function account_update_profile_image($image='') {
		$params = array();

		$params['image'] = $image;

		$retval = $this->call('POST', TRUE, 'account/update_profile_image', $params);
		return $retval;
	}


	/* account/update_profile_background_image - http://dev.twitter.com/doc/post/account/update_profile_background_image */
	public function account_update_profile_background_image($image='', $tile=FALSE) {
		$params = array();

		$params['image'] = $image;
		if($tile!==FALSE) $params['tile'] = $tile;

		$retval = $this->call('POST', TRUE, 'account/update_profile_background_image', $params);
		return $retval;
	}


	/* account/update_profile - http://dev.twitter.com/doc/post/account/update_profile */
	public function account_update_profile($name=FALSE, $url=FALSE, $location=FALSE, $description=FALSE) {
		$params = array();

		if($name!==FALSE) $params['name'] = $name;
		if($url!==FALSE) $params['url'] = $url;
		if($location!==FALSE) $params['location'] = $location;
		if($description!==FALSE) $params['description'] = $description;

		$retval = $this->call('POST', TRUE, 'account/update_profile', $params);
		return $retval;
	}


	/* favorites - http://dev.twitter.com/doc/get/favorites */
	public function favorites($id=FALSE, $page=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($page!==FALSE) $params['page'] = $page;

		$retval = $this->call('GET', TRUE, 'favorites', $params);
		return $retval;
	}


	/* favorites/create - http://dev.twitter.com/doc/post/favorites/create */
	public function favorites_create($id=0) {
		$params = array();

		$params['id'] = $id;

		$retval = $this->call('POST', TRUE, 'favorites/create', $params);
		return $retval;
	}


	/* favorites/destroy - http://dev.twitter.com/doc/post/favorites/destroy */
	public function favorites_destroy($id=0) {
		$params = array();

		$params['id'] = $id;

		$retval = $this->call('POST', TRUE, 'favorites/destroy', $params);
		return $retval;
	}


	/* notifications/follow - http://dev.twitter.com/doc/post/notifications/follow */
	public function notifications_follow($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'notifications/follow', $params);
		return $retval;
	}


	/* notifications/leave - http://dev.twitter.com/doc/post/notifications/leave */
	public function notifications_leave($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'notifications/leave', $params);
		return $retval;
	}


	/* blocks/create - http://dev.twitter.com/doc/post/blocks/create */
	public function blocks_create($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'blocks/create', $params);
		return $retval;
	}


	/* blocks/destroy - http://dev.twitter.com/doc/post/blocks/destroy */
	public function blocks_destroy($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'blocks/destroy', $params);
		return $retval;
	}


	/* blocks/exists - http://dev.twitter.com/doc/get/blocks/exists */
	public function blocks_exists($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('GET', TRUE, 'blocks/exists', $params);
		return $retval;
	}


	/* blocks/blocking - http://dev.twitter.com/doc/get/blocks/blocking */
	public function blocks_blocking($page=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('GET', TRUE, 'blocks/blocking', $params);
		return $retval;
	}


	/* blocks/blocking/ids - http://dev.twitter.com/doc/get/blocks/blocking/ids */
	public function blocks_blocking_ids() {
		$params = array();

		$retval = $this->call('GET', TRUE, 'blocks/blocking/ids', $params);
		return $retval;
	}


	/* report_spam - http://dev.twitter.com/doc/post/report_spam */
	public function report_spam($id=FALSE, $user_id=FALSE, $screen_name=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;
		if($user_id!==FALSE) $params['user_id'] = $user_id;
		if($screen_name!==FALSE) $params['screen_name'] = $screen_name;

		$retval = $this->call('POST', TRUE, 'report_spam', $params);
		return $retval;
	}


	/* saved_searches - http://dev.twitter.com/doc/get/saved_searches */
	public function saved_searches() {
		$params = array();

		$retval = $this->call('GET', TRUE, 'saved_searches', $params);
		return $retval;
	}


	/* saved_searches/show - http://dev.twitter.com/doc/get/saved_searches/show */
	public function saved_searches_show($saved_search_id=0) {
		$params = array();

		$params['saved_search_id'] = $saved_search_id;

		$retval = $this->call('GET', TRUE, 'saved_searches/show', $params);
		return $retval;
	}


	/* saved_searches/create - http://dev.twitter.com/doc/post/saved_searches/create */
	public function saved_searches_create($id=FALSE) {
		$params = array();

		if($id!==FALSE) $params['id'] = $id;

		$retval = $this->call('POST', TRUE, 'saved_searches/create', $params);
		return $retval;
	}


	/* saved_searches/destroy - http://dev.twitter.com/doc/post/saved_searches/destroy */
	public function saved_searches_destroy($saved_search_id=FALSE) {
		$params = array();

		if($saved_search_id!==FALSE) $params['saved_search_id'] = $saved_search_id;

		$retval = $this->call('POST', TRUE, 'saved_searches/destroy', $params);
		return $retval;
	}


	/* oauth/request_token - http://dev.twitter.com/doc/post/oauth/request_token */
	public function oauth_request_token() {
		$params = array();

		$retval = $this->call('POST', FALSE, 'oauth/request_token', $params);
		return $retval;
	}


	/* oauth/authorize - http://dev.twitter.com/doc/get/oauth/authorize */
	public function oauth_authorize() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'oauth/authorize', $params);
		return $retval;
	}


	/* oauth/authenticate - http://dev.twitter.com/doc/get/oauth/authenticate */
	public function oauth_authenticate() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'oauth/authenticate', $params);
		return $retval;
	}


	/* oauth/access_token - http://dev.twitter.com/doc/post/oauth/access_token */
	public function oauth_acces_token($x_auth_username=FALSE, $x_auth_password=FALSE, $x_auth_mode=FALSE) {
		$params = array();

		if($x_auth_username!==FALSE) $params['x_auth_username'] = $x_auth_username;
		if($x_auth_password!==FALSE) $params['x_auth_password'] = $x_auth_password;
		if($x_auth_mode!==FALSE) $params['x_auth_mode'] = $x_auth_mode;

		$retval = $this->call('POST', FALSE, 'oauth/access_token', $params);
		return $retval;
	}


	/* trends/available - http://dev.twitter.com/doc/get/trends/available */
	public function trends_available($lat_for_trends=FALSE, $lon_for_trends=FALSE) {
		$params = array();

		$retval = $this->call('GET', FALSE, 'trends/available', $params);
		return $retval;
	}


	/* trends/location - http://dev.twitter.com/doc/get/trends/location */
	public function trends_location($woeid=0) {
		$params = array();

		$params['woeid'] = $woeid;

		$retval = $this->call('GET', FALSE, 'trends/location', $params);
		return $retval;
	}


	/* geo/reverse_geocode - http://dev.twitter.com/doc/get/geo/reverse_geocode */
	public function geo_reverse_geocode($lat=0, $long=0, $accuracy=FALSE, $granularity=FALSE, $max_results=FALSE) {
		$params = array();

		$params['lat'] = $lat;
		$params['long'] = $long;
		if($accuracy!==FALSE) $params['accuracy'] = $accuracy;
		if($granularity!==FALSE) $params['granularity'] = $granularity;
		if($max_results!==FALSE) $params['max_results'] = $max_results;

		$retval = $this->call('GET', FALSE, 'geo/reverse_geocode', $params);
		return $retval;
	}


	/* geo/id - http://dev.twitter.com/doc/get/geo/id */
	public function geo_id($place_id=0) {
		$params = array();

		$params['place_id'] = $place_id;

		$retval = $this->call('GET', FALSE, 'geo/id', $params);
		return $retval;
	}


	/* help/test - http://dev.twitter.com/doc/get/help/test */
	public function help_test() {
		$params = array();

		$retval = $this->call('GET', FALSE, 'help/test', $params);
		return $retval;
	}


	/* Custom functions */

	/* Return id for screen_name */
	public function get_id_by_screenname($screenname='') {
		$retval = array();

		$retval = $this->users_show($screenname);
		$retval = $retval['id'];

		return $retval;
	}

}
?>
