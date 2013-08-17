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

require('index.php');
?>
<html>
<head>
<title><?= $site_name ?></title>
</head>
<frameset cols="300,*" border="0" frameborder="1">
	<frame id="left" name="left" src="nav" scrolling="auto" noresize frameborder="1" />
	<frame id="right" name="right" src="home" scrolling="auto" noresize frameborder="1" />
</frameset>
</html>