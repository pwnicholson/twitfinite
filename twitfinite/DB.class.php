<?
class DB {
	public $debug, $conn;
	private $db_type, $dsn, $l_delim, $r_delim;


	function __construct($dsn=array()) {
		$err = array();
		if(!isset($dsn['db_host'])) $err[] = 'Missing db_host';
		if(!isset($dsn['db_user'])) $err[] = 'Missing db_user';
		if(!isset($dsn['db_pass'])) $err[] = 'Missing db_pass';
		if(!isset($dsn['db_type'])) $err[] = 'Missing db_type';

		if(count($err)>0)
			$this->err($err);

		$this->dsn = $dsn;
		$this->db_type = $this->dsn['db_type'];
		$this->debug = FALSE;
		$this->connect();
		$this->get_delimiters();
	}


	function __destruct() {
		switch($this->db_type) {
			case 'mysql':
				mysql_close($this->conn);
				break;
		}
	}


	private function connect() {
		switch($this->db_type) {
			case 'mysql':
				$this->conn = mysql_connect($this->dsn['db_host'], $this->dsn['db_user'], $this->dsn['db_pass'], TRUE);
				mysql_select_db($this->dsn['db_name'], $this->conn);
				break;
		}
	}


	private function err($err=array()) {
		foreach($err as $e)
			echo $e."\n";

		exit;
	}


	private function get_delimiters() {
		switch($this->db_type) {
			case 'mysql':
				$this->l_delim = '`';
				$this->r_delim = '`';
				break;
		}

		return TRUE;
	}


	public function query($query) {
		if($this->debug) echo "[QUERY]\t".$query."\n";
		switch($this->db_type) {
			case 'mysql':
				return mysql_query($query, $this->conn);
				break;
		}
	}


	public function q($query) {
		return $this->query($query);
	}


	public function fetch_assoc($result) {
		switch($this->db_type) {
			case 'mysql':
				return mysql_fetch_assoc($result);
				break;
		}
	}


	public function fetch_array($result) {
		return $this->fetch_assoc($result);
	}


	public function q_fetch_all($query, $row_num=FALSE, $field=FALSE) {
		$retval = array();

		$result = $this->query($query);
		while($row=$this->fetch_assoc($result)) {
			if($field!==FALSE)
				$retval[] = $row[$field];
			else
				$retval[] = $row;
		}

		if($row_num!==FALSE)
			$retval = $retval[$row_num];

		return $retval;
	}


	public function result($result, $field=0, $row=0) {
		switch($this->db_type) {
			case 'mysql':
				return @mysql_result($result, $row, $field);
				break;
		}
	}


	public function q_result($query, $field=0, $row=0) {
		$result = $this->query($query);

		return $this->result($result, $field, $row);
	}


	public function q_num_rows($query) {
		switch($this->db_type) {
			case 'mysql':
				return mysql_num_rows($this->q_result($query));
				break;
		}
	}


	public function insert_id() {
		$retval = FALSE;

		switch($this->db_type) {
			case 'mysql':
				$retval = mysql_insert_id($this->conn);
				break;
		}

		return $retval;
	}


	public function build_insert($table='', $params=array()) {
		$query = "INSERT INTO ".$this->l_delim.$table.$this->r_delim." (";
		$query .= $this->l_delim.implode($this->r_delim.','.$this->l_delim, array_keys($params)).$this->r_delim.") VALUES ('";

		switch($this->db_type) {
			case 'mysql':
				foreach($params as $p_k => $p_v)
					$params[$p_k] = addslashes($p_v);
				$query .= implode("','", $params)."')";
				break;
		}

		return $query;
	}


	public function insert($table='', $params=array()) {
		$retval = FALSE;

		$query = $this->build_insert($table, $params);
		$this->query($query);

		$retval = $this->insert_id();
		return $retval;
	}


	public function ping() {
		return mysql_ping($this->conn);
	}
}
?>