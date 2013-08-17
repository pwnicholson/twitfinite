<?
class cURL {
	public $debug;
	private $curl;


	function __construct($opts) {
		$this->curl = curl_init();

		$this->setopt($opts);

		$this->debug = FALSE;
	}


	function __destruct() {
		curl_close($this->curl);
	}


	public function setopt($var,$val=FALSE) {
		if(is_array($var))
			curl_setopt_array($this->curl, $var);
		else
			if($var!==FALSE && $val!=FALSE)
				curl_setopt($this->curl, $var, $val);
	}


	public function call() {
		/* Check if debugging is enabled */
		if($this->debug) {
			# Do nothing, this stuff is annoying
			/* curl_setopt_array($this->curl, array(
				CURLOPT_HEADER => TRUE,
				CURLINFO_HEADER_OUT => TRUE,
				CURLOPT_VERBOSE => TRUE
			)); */

			#print_r(curl_getinfo($this->curl));
		}

		return curl_exec($this->curl);
	}
}

?>