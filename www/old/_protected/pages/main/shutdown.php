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
if(eregi('shutdown.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

/*
This is called at the end of every page.
Useful for closing database connections and unsetting variables.
*/
if(strlen(implode('',$master_dsn))>0) $master->disconnect();
?>