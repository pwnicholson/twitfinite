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

/*
This file does the absolute bare minimum that it has to.  It gets called for
each web request, determines if it's the dev or live site and then finds
the protected directory for all the other includes.
*/

/*
Is this the dev site or the live site?
A better way to set this would be to customize the $live_hostname variable below.
*/
$dev = FALSE;

/*
Enter the hostname for the production version of this site.  Any other hostnames
that this code is accessed by will be considered dev.
*/
$live_hostname = 'old.twitfinite.com';
if($_SERVER['HTTP_HOST']!=$live_hostname) $dev = TRUE;
$dev = FALSE;

/*
Where are the protected files?
For added security, you may want to place the protected directory outside
of the web-accessible filesystem.  Either way will work, though.
*/
if($dev) {
	$protected = '_protected/';
} else {
	$protected = '_protected/';
}

/* With the $dev and $protected variables set, let's bootstrap the rest! */
require_once($protected.'includes/bootstrap.php');
?>
