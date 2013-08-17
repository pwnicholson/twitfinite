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
if(eregi('Validator.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');


class Validator {
	/* Recursively sanitizes (trims and strips tags) an array */
	public function sanitize($arr) {
		$keys = array_keys($arr);
		for($i=0;$i<count($keys);$i++) {
			if(is_array($arr[$keys[$i]])) {
				$arr[$keys[$i]] = Validator::sanitize($arr[$keys[$i]]);
			} else {
				$arr[$keys[$i]] = stripslashes(trim(strip_tags($arr[$keys[$i]])));
			}
		}
		return($arr);
	}

	/* Check if something is empty */
	public function check_empty($str='') {
		if(strlen(trim($str))==0) $str = '&nbsp;';
		return trim($str);
	}

	/* Alias for check_empty */
	public function ce($str='') {
		return $this->check_empty($str);
	}

	/* Checks if it is an e-mail address */
	public function is_email($str='') {
		$pattern = '/^.+@[^\.].*\.[a-z]{2,}$/';
		if(preg_match($pattern,$str)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/* Checks for a valid IP address */
	public function check_ip($str='') {
		$pattern = '/(?:\d{1,3}\.){3}\d{1,3}/';
		if(preg_match($pattern,$str)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/* Checks for a valid MAC address */
	public function check_mac($str='') {
		$str = strtoupper($str);
		$pattern = '/[A-F0-9]{12}/';
		if(preg_match($pattern,$str,$matches)) {
			return $str;
		} else {
			return FALSE;
		}
	}

	/* Merges POST and Database arrays, with preference to POST */
	/* Useful for edit pages where the POST variable may be overwritten */
	public function post_merge($post_arr,$db_arr) {
		$new_arr = array();

		/* Loop through db_arr */
		$keys = array_keys($db_arr);
		for($i=0;$i<count($keys);$i++) {
			if(@strlen($post_arr[$keys[$i]])>0) {
				$new_arr[$keys[$i]] = $post_arr[$keys[$i]];
			} else {
				$new_arr[$keys[$i]] = $db_arr[$keys[$i]];
			}
		}

		/* Loop through post_arr in case we missed anything */
		$keys = array_keys($post_arr);
		for($i=0;$i<count($keys);$i++) {
			if(@!$new_arr[$keys[$i]]) $post_arr[$keys[$i]];
		}

		return $new_arr;
	}
}
?>