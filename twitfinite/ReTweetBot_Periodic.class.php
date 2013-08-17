<?
/* TO DO
 *  - Write update_counts()
 */
class ReTweetBot_Periodic extends ReTweetBot {


	function __construct($id=0) {
		parent::__construct($id);
	}

	
	function __destruct() {

	}


	public function update_followers() {
		if($this->opt['autofollow']==1)
				$this->autofollow();

		#if($this->opt['new_followers_update_interval']>0)
		#	$this->new_followers_update();
	}


	/* Check to see if we need to send out an update for new followers */
	public function new_followers_update() {
		$retval = FALSE;

		$new_followers = $this->counts['followers_count']-$this->opt['new_followers_last_update_count'];

		if($new_followers>=$this->opt['new_followers_update_interval']) {
			$retval = $this->t->statuses_update($this->opt['new_followers_update_tweet']);

			if(!isset($retval['error'])) {
				$this->log($this->opt['twitter_screenname'].': Posted new followers update ('.$retval['id'].')');
			} else {
				$this->log($this->opt['twitter_screenname'].': Failed to post new followers update, '.$retval['error']);
			}

			$query = <<<EOQ
UPDATE
	`groups`
SET
	`new_followers_last_update_count`={$this->counts['followers_count']},
	`new_followers_last_update_ts=NOW()
EOQ;
			$this->db->q($query);
		} else {
			$this->log($this->opt['twitter_screenname'].': Not enough new followers, Have: '.$this->counts['followers_count'].', Need: '.($this->counts['followers_count']+$this->opt['new_followers_update_interval']));
		}

		return $retval;
	}


	/* Follow new followers */
	public function autofollow() {
		$followers = $this->t->followers_ids();
		$friends = $this->t->friends_ids();

		$diff = array_diff($followers, $friends);

		$followed = array();
		$query = "SELECT `twitter_user_id` FROM `groups_followed` WHERE `group_id`=".$this->id;
		$followed_db = $this->db->q_fetch_all($query);
		foreach($followed_db as $f)
			$followed[] = $f['twitter_user_id'];

		foreach($diff as $f) {
			$follow = TRUE;

			/* Make sure we haven't followed them before */
			if(in_array($f,$followed)) {
				$follow = FALSE;
				$this->log($this->opt['twitter_screenname'].': Not following '.$f.', Already followed before');
			}


			/* Make sure they're not on the blacklist */
			if($this->blacklist_check($f))
				$follow = FALSE;


			if($follow) {
				/* Make sure they're under the cap limit */
				$prospect = $this->t->users_show(FALSE, $f);

				if($prospect['followers_count']>$this->opt['follow_cap']) {
					$follow = FALSE;
					$this->log($this->opt['twitter_screenname'].': Not following '.$f.', Follower count: '.$prospect['followers_count'].', Cap: '.$this->opt['follow_cap']);
				}
			}

		}
	}


	/* Update statuses count */
	public function update_counts() {
		
	}
}
?>