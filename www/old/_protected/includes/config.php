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
if(eregi('config.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

/* Database config variables */
if($dev) {
	$master_dsn = array(
		'db_host' => 'localhost',
		'db_user' => 'retweetbot',
		'db_pass' => 'jkALCT4H',
		'db_name' => 'retweetbot',
		'db_type' => 'mysql'
	);
} else {
	$master_dsn = array(
		'db_host' => 'localhost',
		'db_user' => 'retweetbot',
		'db_pass' => 'jkALCT4H',
		'db_name' => 'retweetbot',
		'db_type' => 'mysql'
	);
}

/* The "root" path relative to the web site */
if($dev) {
	$root = '/';
} else {
	$root = '/';
}

$version = '1';

/* Define a default site name */
$site_name = 'RetweetBot.com';
#if(@$version) $site_name .= " ".$version;

/* Define a default page title */
if(@!$title) $title = "Home";

/* When to post updates for big stuff */
$updates_at_percent = .05;
?>
