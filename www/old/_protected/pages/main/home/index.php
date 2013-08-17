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
if(eregi('pages/main/home/index.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

switch($url[1]) {
	case 'about':
		$include = 'about';
		$title = 'About';
		break;
	case 'directory':
		require('directory.php');
		$include = 'directory';
		$title = 'Bot Directory';
		break;
	case 'userguide':
		$include = 'userguide';
		$title = 'User Guide';
		break;
	case 'adminguide':
		$include = 'adminguide';
		$title = 'Admin Guide';
		break;
	case 'signup':
		require('signup.php');
		$include = 'signup';
		$title = 'Sign Up';
		break;
	case 'contact':
		require('contact.php');
		$include = 'contact';
		$title = 'Contact Us';
		break;
	case 'login':
		require('login.php');
		$include = 'login';
		$title = 'Log In';
		break;
	default:
		require('home.php');
		$include = 'home';
		$title = 'Home';
		$title_alt = 'ReTweetBot Announcements and Updates';
}
?>