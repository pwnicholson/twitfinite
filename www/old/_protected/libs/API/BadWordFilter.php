<?
/*
Credits: Bit Repository
*/

class Filter_String  {

	var $strings;
	var $text;
	var $keep_first_last;
	var $replace_matches_inside_words;
	
	function filter() {
		$new_text = '';
	
		$regex = '/<\/?(?:\w+(?:=["\'][^\'"]*["\'])?\s*)*>/'; // Tag Extractor
	
		preg_match_all($regex, $this->text, $out, PREG_OFFSET_CAPTURE);
		
		$array = $out[0];
		
		if(!empty($array)) {
			if($array[0][1] > 0) {
				$new_text .= $this->do_filter(substr($this->text, 0, $array[0][1]));
			}
	
			foreach($array as $value) {
				$tag = $value[0];
				$offset = $value[1];
				
				$strlen = strlen($tag); // characters length of the tag
				
				$start_str_pos = ($offset + $strlen); // start position for the non-tag element
				$next = next($array);
				
				// end position for the non-tag element
				$end_str_pos = $next[1];
				
				// no end position? This is the last text from the string and it is not followed by any tags
				if(!$end_str_pos) $end_str_pos = strlen($this->text);
				
				// Start constructing the new resulted string. We'll add tags now!
				$new_text .= substr($this->text, $offset, $strlen);
				
				$diff = ($end_str_pos - $start_str_pos);
				
				if($diff > 0) { // Is this a simple string without any tags? Apply the filter to it
					$str = substr($this->text, $start_str_pos, $diff);
					
					$str = $this->do_filter($str);
					
					$new_text .= $str; // Continue constructing the text with the (filtered) text
				}
			}
		} else { // No tags were found in the string? Just apply the filter
			$new_text = $this->do_filter($this->text);
		}
			
		return $new_text;
	}

	function do_filter($var) {
		if(is_string($words)) $this->strings = array($this->strings);
		
			foreach($this->strings as $word) {
				$word = trim($word);
			
				$replacement = '';
			
				$str = strlen($word);
			
				$first = ($this->keep_first_last) ? $word[0] : '';
				$str = ($this->keep_first_last) ? $str - 2 : $str;
				$last = ($this->keep_first_last) ? $word[strlen($word) - 1] : '';
			
				$replacement = str_repeat('*', $str);
			
			if($this->replace_matches_inside_words) {
				$var = str_replace($word, $first.$replacement.$last, $var);
			} else {
				$var = preg_replace('/\b'.$word.'\b/i', $first.$replacement.$last, $var);
			}
		}
		
		return $var;
	}

}


function badword_filter($bot_id=0,$str='') {
	global $conn;
	
	$query = "SELECT badwords_filter,use_default_badwords FROM groups WHERE id=".$bot_id;
	$result = mysql_query($query,$conn);
	$filter_type = mysql_result($result,0,'badwords_filter');
	$filter_default = mysql_result($result,0,'use_default_badwords');
	
	switch($filter_type) {
		case 'b':	# Block entire post
			return badword_filter_block($bot_id,$str,$filter_default);
			break;
		case 'c':	# Censor with ****
			return badword_filter_censor($bot_id,$str,$filter_default);
			break;
		case 'd':	# Delete word
			return badword_filter_delete($bot_id,$str,$filter_default);
			break;
		default:
			return $str;
	}
}


function badword_filter_block($bot_id=0,$str='',$default=0) {
	global $conn;
	
	$query = "SELECT badword FROM group_badwords WHERE group_id=".$bot_id;
	$result = mysql_query($query,$conn);
	$badwords = array();
	while($row=mysql_fetch_assoc($result)) {
		$badwords[] = $row['badword'];
	}
	
	$filter = new Filter_String;

	$filter->strings = $badwords;
	
	$filter->text = $str;
	
	$filter->keep_first_last = TRUE;
	$filter->replace_matches_inside_words = FALSE;
	
	$new_text = $filter->filter();
	
	if($str!=$new_text) {
		return FALSE;
	} else {
		return $str;
	}
}


function badword_filter_censor($bot_id=0,$str='',$default=0) {
	global $conn;
	
	$query = "SELECT badword FROM group_badwords WHERE group_id=".$bot_id;
	if($default==1) {
		$query .= " UNION ALL SELECT badword FROM badwords";
	}
	$result = mysql_query($query,$conn);
	$badwords = array();
	while($row=mysql_fetch_assoc($result)) {
		$badwords[] = $row['badword'];
	}
	
	$filter = new Filter_String;

	$filter->strings = $badwords;
	
	$filter->text = $str;
	
	$filter->keep_first_last = TRUE;
	$filter->replace_matches_inside_words = FALSE;
	
	$new_text = $filter->filter();
	
	return $new_text;
}


function badword_filter_delete($bot_id=0,$str='',$default=0) {
	global $conn;
	
	$query = "SELECT badword FROM group_badwords WHERE group_id=".$bot_id;
	if($default==1) {
		$query .= " UNION ALL SELECT badword FROM badwords";
	}
	$result = mysql_query($query,$conn);
	$badwords = array();
	while($row=mysql_fetch_assoc($result)) {
		$badwords[] = $row['badword'];
	}
	
	$filter = new Filter_String;

	$filter->strings = $badwords;
	
	$filter->text = $str;
	
	$filter->keep_first_last = TRUE;
	$filter->replace_matches_inside_words = FALSE;
	
	$new_text = $filter->filter();
	
	$str_arr = explode(' ',$str);
	$new_text_arr = explode(' ',$new_text);
	
	$ret_arr = array();
	for($a=0;$a<count($str_arr);$a++) {
		if($str_arr[$a]==$new_text_arr[$a]) {
			$ret_arr[] = $str_arr[$a];
		}
	}
	
	$ret_str = implode(' ',$ret_arr);
	
	return $ret_str;
}


?>