<?
/*
	 Copyright 2007 Garrett Bartley.

    This file is part of Munkee's Framework.

    Munkee's Framework is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Munkee's Framework is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Munkee's Framework.  If not, see <http://www.gnu.org/licenses/>.
*/

/* Page protection in case the .htaccess file is hosed */
if(eregi('functions.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');


/* Connect to a database with a DSN (array or string) */
function db_connect($dsn) {
	$options = array('debug' => 2, 'result_buffering' => true);
	if(is_array($dsn)) $dsn = build_dsn($dsn);
	$conn =& MDB2::factory($dsn, $options);
	if (PEAR::isError($conn)) {
		echo $conn->getMessage();
	}
	$conn->setFetchMode(MDB2_FETCHMODE_ASSOC);
	/* This query is run to check and make sure the connection is successfull */
	$query = "SELECT 1+1";
	q($query,$conn);

	return $conn;
}

/* Perform a SQL query */
function q($sql,$conn) {
	$dev = FALSE;

	$res =& $conn->query($sql);
	if(PEAR::isError($res)) {
		if($dev) {
			echo $res->getMessage().'<br />';
			echo '<pre>';
			print_r($conn->dsn);
			echo '</pre>';
		}
		return FALSE;
	} else {
		return $res;
	}
}


/* Build the DSN string from an array */
function build_dsn($arr) {
	global $dev;
	if($dev) $arr['db_host'] = ip_trans($arr['db_host']);

	if(count($arr)==5) {
		$dsn = $arr['db_type'].'://'.$arr['db_user'].':'.$arr['db_pass'].'@'.$arr['db_host'].'/'.$arr['db_name'];
	} else {
		$dsn = FALSE;
	}

	return $dsn;
}

/* A weird way to do an if with an array */
function array_if($arr,$op,$val) {
	$ret = TRUE;
	for($a=0;$a<count($arr);$a++) {
		$if = 'if( '.$arr[$a].' '.$op.' '.$val.' ) { return TRUE; } else { return FALSE; }';
		$if = eval($if);
		if(!$if && $ret) $ret = FALSE;
	}

	return $ret;
}


/* Build an INSERT query from an array */
function build_insert($table,$arr) {
	$keys = array_keys($arr);
	for($a=0;$a<count($keys);$a++) {
		$values[] = str_replace("'","''",$arr[$keys[$a]]);
	}

	$str = "INSERT INTO `".$table."` (`".implode('`,`',$keys)."`) VALUES ('".implode("','",$values)."')";

	return $str;
}

/* Build an UPDATE query from an array */
/* The $where is a string (e.g. "id=123") */
function build_update($table,$arr,$where) {
	$str = "UPDATE `".$table."` SET ";
	$keys = array_keys($arr);
	for($a=0;$a<count($keys);$a++) {
		$updates[] = "`".$keys[$a]."`='".str_replace("'","''",$arr[$keys[$a]])."'";
	}

	$str .= implode(',',$updates).' WHERE '.$where;

	return $str;
}

/* Do a redirect within the site */
function redirect($url='') {
	if(strlen(trim($url))>0) header('location: '.$root.$url);
}

/* This simply removes all non-alpha, non-number characters */
function scrub($str) {
	$str = preg_replace('/[^A-Za-z0-9]/','',$str);
	return $str;
}

function scrubwithspaces($str) {
	$str = preg_replace('/[^A-Za-z0-9 ]/','',$str);
	return $str;
}

function scrubdbdefaults($str) {
	$str = substr($str,2,strlen($str)-4);
	return $str;
}

function get_group_info($bot_id=0) {
	global $master;
	
	$query = "SELECT id AS group_id,twitter_email,twitter_screenname,twitter_password,show_names,use_replies,use_directmessages FROM groups WHERE id=".$bot_id;
	$result = q($query,$master);
	$row = $result->fetchAll();
	$result->free();
	
	return $row[0];
}

function array_binary_yesno($arr) {
	$keys = array_keys($arr);
	foreach($keys as $key) {
		if($arr[$key]=='0') {
			$arr[$key] = 'No';
		} elseif ($arr[$key]=='1') {
			$arr[$key] = 'Yes';
		}
	}
	
	return $arr;
}

function autolink_twitter($str) {
	$pattern = '/\@([A-Za-z0-9\_]+)/';
	preg_match_all($pattern,$str,$matches);
	
	for($a=0;$a<count($matches[0]);$a++) {
		$str = str_replace($matches[0][$a],'<a href="http://twitter.com/'.$matches[1][$a].'" target="twitter">'.$matches[0][$a].'</a>',$str);
	}
	
	return $str;
}


function autolink_url($str) {	
	$pattern = '[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]';
	
	return ereg_replace($pattern,'<a href="\\0" target="_blank">\\0</a>',$str);
}


function calc_time_ago($ts) {
	$now = mktime();
	
	$diff = $now-$ts;
	
	if($diff<=5) {
		$new_ts = "5 seconds ago";
	} elseif($diff<=10) {
		$new_ts = "10 seconds ago";
	} elseif($diff<=15) {
		$new_ts = "15 seconds ago";
	} elseif($diff<=30) {
		$new_ts = "Half a minute ago";
	} elseif($diff<60) {
		$new_ts = "Less than a minute ago";
	} elseif ($diff<90) {
		$new_ts = "1 minute ago";
	} elseif ($diff<3600) {
		$new_ts = round($diff/60)." minutes ago";
	} elseif ($diff<86400) {
		$new_ts = "about ".round($diff/3600)." hours ago";
	} else {
		$new_ts = date("g:i A T M jS",$ts);
		if(date("Y",$ts)!=date("Y",$now)) $new_ts .= date(", Y",$ts);
	}
	
	return $new_ts;
}
?>