<?
if($url[2]) {
	$year = intval($url[2]);
} else {
	$year = date("Y");
}

if($url[3]) {
	$month = intval($url[3]);
} else {
	$month = date("m");
}

$date = mktime(0,0,0,$month,1,$year);
$date_dayone = mktime(0,0,0,date("m",$date),1,date("Y",$date));
$date_daylast = mktime(0,0,0,(date("m",$date)+1),1,date("Y",$date));

$days = array();
$dayone = date("w",$date_dayone);
$daylast = date("w",$date_daylast)-1;
$numdays = date("t",$date);

for($a=0;$a<$dayone;$a++) {
	$days[$a] = '';
}

for($a=$dayone;$a<($numdays+$dayone);$a++) {
	$date_loop = mktime(0,0,0,date("m",$date),($a-$dayone+1),date("Y",$date));
	$days[$a] = intval(date("d",$date_loop));
}

$cal_end = $a+(6-$daylast);

for($a=count($days);$a<$cal_end;$a++) {
	$days[$a] = '';
}


$smarty->assign('month_year',date("F Y",$date));
$smarty->assign('days',$days);

$smarty->assign('calendar',$html);


$include = 'calendar/calendar';
?>