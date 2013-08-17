<?
/* Returns 1 for TRUE, 0 for FALSE */
function tf10($var=FALSE) {
	$retval = 0;

	if($var)
		$retval = 1;
	else
		$retval = 0;
	
	return $retval;
}

?>
