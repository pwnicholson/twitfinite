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
if(eregi('Timestamp.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

class Timestamp {

	/* Get the current date and time */
	public function get() {
		return date("Y-m-d H:i:s");
	}

	/* Parses a MySQL 5 timestamp and returns it with PHP date() formatting */
	function parse($str="",$dt='date',$format='n/j/y') {
		$pattern = '/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/';
		if(preg_match($pattern,$str,$matches)) {
			if($dt=='date') {
				$date = mktime(0,0,0,$matches[2],$matches[3],$matches[1]);
				return date($format,$date);
			} elseif ($dt=='time') {
				$date = mktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$matches[1]);
				return date($format,$date);
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

}
?>