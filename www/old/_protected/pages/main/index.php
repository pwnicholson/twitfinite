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
if(eregi('pages/main/index.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

if(@$tab_title) {
	$smarty->assign('tab_title',$tab_title);
} elseif(@$tabs) {
	$smarty->assign('tabs',$tabs);
}

ksort($url);

$css_time = filemtime('_css/stylesheet.css');
$smarty->assign('css_time',$css_time);

$fullurl = $root.implode('/',$url);
$smarty->assign('fullurl',$fullurl);

$smarty->assign('user_id',$_s->get('user_id'));
$smarty->assign('admin',$_s->get('admin'));

$smarty->display('index.tpl');
?>