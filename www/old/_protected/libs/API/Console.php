<?
class Console {
	public $group_id;
	public $twitter_user_id;
	public $status_id;
	public $status;
	public $twitter_screenname;
	public $command;
	public $args;
	public $group;
	public $conn;
	
	function __construct($group_id=0, $twitter_user_id=0, $status_id=0, $status='') {
		global $conn;
		$this->conn = $conn;
		
		$this->group_id = $group_id;
		$this->twitter_user_id = $twitter_user_id;
		$this->status_id = $status_id;
		$this->status = $status;
		
		$query = "SELECT * FROM groups WHERE id=".$this->group_id;
		$result = mysql_query($query,$this->conn);
		$this->group = mysql_fetch_assoc($result);
	}
	
	function process_command() {
		$pattern = '/(\w+)\|(.+)/';
		if(preg_match($pattern,$this->status,$matches) || $this->status=='help|') {
			if($matches) {
				$this->command = $matches[1];
				$this->args = $matches[2];
			} elseif($this->status=='help|') {
				$this->command = 'help';
				$this->args = '';
			}
			
			if($this->check_is_admin()) {
				if($this->check_already_performed()) {
					switch($this->command) {
						case 'u':
							$this->command_u();
							break;
						case 'block':
							$this->command_block();
							break;
						case 'dma':
							$this->command_dma();
							break;
						case 'hash':
							$this->command_hash();
							break;
						case 'del':
							$this->command_del();
							break;
						case 'nuke':
							$this->command_nuke();
							break;
						case 'kill':
							$this->command_nuke();
							break;
						case 'help':
							$this->command_help();
							break;
						default:
							break;
					}
					
					$this->insert_command();
				}
			}
			return FALSE;
		} else {
			return $this->status;
		}
	}
	
	private function check_is_admin() {
		$query = "SELECT id FROM group_admins WHERE group_id=".$this->group_id." AND twitter_user_id=".$this->twitter_user_id;
		$result = mysql_query($query,$this->conn);
		if(mysql_num_rows($result)>0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
	private function check_already_performed() {
		$query = "SELECT id FROM console_commands WHERE group_id=".$this->group_id." AND status_id=".$this->status_id." AND twitter_user_id=".$this->twitter_user_id;
		$result = mysql_query($query, $this->conn);
		if(mysql_num_rows($result)==0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
	private function insert_command() {
		$_u = new User($this->group);
		$show = $_u->show($this->twitter_user_id);
		$this->twitter_screenname = trim($show->screen_name);

		$this->status = addslashes($this->status);
		
		$query = <<<EOQ
INSERT INTO console_commands (
	group_id,
	status_id,
	twitter_screenname,
	twitter_user_id,
	command
) VALUES (
	{$this->group_id},
	{$this->status_id},
	'{$this->twitter_screenname}',
	{$this->twitter_user_id},
	'{$this->status}'
)
EOQ;
		mysql_query($query,$this->conn);
	}
	
	
	private function confirm($message='') {
		if($this->group['confirm_command_dm']==0) {
			$_dm = new DirectMessage($this->group);
		
			if(strlen($this->args)>100) {
				$status = substr($status,0,99).'...';
			}
			
			$text = 'Command "'.$this->command.'|'.$this->args.'" issued successfully!';
			if(strlen(trim($message))>0) $text .= ' '.$message;
			
			$confirm = $_dm->_new($this->twitter_user_id,$text);
			
			_log($this->group['twitter_screenname'].": command confirmation message sent (".$confirm->id.")");
		} else {
			_log($this->group['twitter_screenname'].": command confirmation message disabled");
		}
	}
	
	private function command_u() {
		$_s = new Status($this->group);
		$_s = $_s->update($this->args);
		
		_log($this->group['twitter_screenname'].": issue command=".$this->command.", status=".$_s->id);
		
		$this->confirm();
	}
	
	private function command_block() {
		$_u = new User($this->group);
		$show = $_u->show($this->args);
		
		if($show->error=='Not found') {
			_log($this->group['twitter_screenname'].": issue command=".$this->command." twitter_screenname=".$this->args.", invalid user");
			
			$this->confirm($this->args.' invalid user');
		} else {
			$query = "SELECT * FROM group_blacklist WHERE group_id=".$this->group_id." AND twitter_user_id=".$show->id;
			$result = mysql_query($query,$this->conn);
			if(mysql_num_rows($result)==0) {
				$_f = new Friendship($this->group);
				$_f->destroy($show->id);
				
				$_b = new Block($this->group);
				$_b->create($show->id);
				
				$query = "INSERT INTO group_blacklist (group_id,twitter_screenname,twitter_user_id) VALUES (".$this->group_id.",'".$this->args."',".$show->id.")";
				mysql_query($query,$this->conn);
				
				_log($this->group['twitter_screenname'].": issue command=".$this->command.", twitter_screenname=".$this->args.", twitter_user_id=".$show->id);
				
				$this->confirm($this->args.' blocked');
			} else {
				_log($this->group['twitter_screenname'].": issue command=".$this->command.", twitter_screenname=".$this->args.", twitter_user_id=".$show->id.", already blocked");
				
				$this->confirm($this->args.' already blocked');
			}
		}
	}
	
	
	private function command_dma() {
		$_dm = new DirectMessage($this->group);
		
		$admins = array();
		$query = "SELECT twitter_user_id FROM group_admins WHERE group_id=".$this->group_id." AND twitter_user_id<>".$this->twitter_user_id;
		$result = mysql_query($query,$this->conn);
		while($row2=mysql_fetch_assoc($result)) {
			$confirm = $_dm->_new($row2['twitter_user_id'],$this->args);
			$admins[] = trim($confirm->recipient_screen_name);
			
			_log($this->group['twitter_screenname'].": direct message to admins sent to ".trim($confirm->recipient_screen_name)." (".$confirm->id.")");
		}
		
		$message = "Message sent to ".implode(', ',$admins);
		
		$this->confirm($message);
	}
	
	
	private function command_hash() {
		$query = "UPDATE groups SET hashtags='".$this->args."' WHERE id=".$this->group_id;
		mysql_query($query,$this->conn);
		
		_log($this->group['twitter_screenname'].": hash tags set to ".$this->args);
		
		$this->confirm("hash tags set to ".$this->args);
	}
	
	
	private function command_del() {
		$arr = explode(' ',$this->args);
		$twitter_screenname = $arr[0];
		
		$_u = new User($this->group);
		$show = $_u->show($twitter_screenname);
		
		if($show->error=='Not found') {
			_log($this->group['twitter_screenname'].": issue command=".$this->command.", twitter_screenname=".$twitter_screenname.", invalid user");
			
			$this->confirm('invalid user '.$twitter_screenname);
		} else {
			if($arr[1]=='all') {
				$count = 'all';
				$query = "SELECT post_status_id FROM tweets WHERE group_id=".$this->group_id." AND twitter_user_id=".$show->id." AND post_status_id IS NOT NULL AND deleted=0";
			} else {
				$count = (int)$arr[1];
				if($count==0) $count = 1;
				$query = "SELECT post_status_id FROM tweets WHERE group_id=".$this->group_id." AND twitter_user_id=".$show->id." AND post_status_id IS NOT NULL AND deleted=0 ORDER BY id DESC LIMIT ".$count;
			}
			
			$i = 0;
			$result = mysql_query($query,$this->conn);
			if(mysql_num_rows($result)>0) {
				$_s = new Status($this->group);
				while($row = mysql_fetch_assoc($result)) {
					$ret = $_s->destroy($row['post_status_id']);
					if(!isset($ret->err)) {
						$query = "UPDATE tweets SET deleted=1 WHERE group_id=".$this->group_id." AND twitter_user_id=".$show->id." AND post_status_id=".$row['post_status_id'];
						mysql_query($query,$this->conn);
						$i++;
					}
				}
			}
			
			_log($this->group['twitter_screenname'].": issue command=".$this->command.", twitter_screenname=".$twitter_screenname.", deleted ".number_format($i)." last post(s)");
			$this->confirm('deleted '.number_format($i).' last post(s)');
		}
	}
	
	
	private function command_nuke() {
		$args = $this->args;
		$this->command = 'del';
		$this->args = $args.' all';
		$this->command_del();
		
		$this->command = 'block';
		$this->args = $args;
		$this->command_block();
	}
	
	private function command_help() {
		$help_message = 'Available commands: u (post update), del (delete), block (block user), nuke (del all + block), hash (start new hashtag), dma (DM admins)';
		$_dm = new DirectMessage($this->group);		
		$_dm->_new($this->twitter_user_id,$help_message);
		
		_log($this->group['twitter_screenname'].": issue command=".$this->command.", twitter_screenname=".$twitter_screenname.", sent help");
	}
}
?>
