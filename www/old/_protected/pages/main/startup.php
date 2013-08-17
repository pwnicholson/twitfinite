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
if(eregi('startup.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

/* This file is pulled every time any page is called */

/* Do URL detection and require the right content page */
if(@!$_g['url']) $_g['url'] = 'home';

/* Redirect to home if no URI was specified */
if(@$_g['url']=='home' && substr($_SERVER['REQUEST_URI'],-4,4)!=$_g['url']) $url[0] = 'home';

/* Set the pages */
foreach(glob($protected.'pages/'.$pagesdir.'/*',GLOB_ONLYDIR) as $dir) {
	$pages[] = basename($dir);
}

/* This will probably be used on every page */
if(strlen(implode('',$master_dsn))>0) {
	$master =& db_connect($master_dsn);
	$master->setOption('quote_identifier',TRUE);
}

/* Make sure it's a legit page */
if(@in_array($url[0],$pages)) {
	require($protected.'pages/'.$pagesdir.'/'.$url[0].'/index.php');
} else {
	require($protected.'pages/404/index.php');
}
?>