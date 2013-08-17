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
if(eregi('bootstrap.php',$_SERVER['PHP_SELF'])) exit('hack attempt . . . denied');

ini_set('session.bug_compat_42','off');

if(!$dev) {
	ini_set('display_errors',0);
} else {
	ini_set('display_errors',1);
}

/*
This file does the "startup" to make sure everything is configured and required.
Hopefully you shouldn't have to touch much of anything except for minor tweaks.
Be careful because one small change could hose the entire site.
*/

/* Get the database and other configuration variables */
require('config.php');
require('functions.php');
require('MDB2.php');
require($protected.'libs/Global/Debug.php');
require($protected.'libs/Global/Session.php');
require($protected.'libs/Global/Validator.php');
require($protected.'libs/Global/Timestamp.php');

/* Get the Twitter API */
require($protected.'libs/API/API.php');

/* Initialize the database and validator classes*/
$_d = new Debug();
$_s = new Session();
$_v = new Validator();
$_ts = new Timestamp();

/* Load up the Smarty templating engine */
require($protected.'Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = $protected.'templates';
$smarty->compile_dir = $protected.'Smarty/templates_c';
$smarty->cache_dir = $protected.'Smarty/cache';
$smarty->config_dir = $protected.'Smarty/configs';

/* Assign some default Smarty variables */
$smarty->assign('root',$root);

/* If we haven't started a session, let's do so now before we load any page code */
if(session_id()=="") {
	/* The IF was created with brackets in case you have to do much more than start the session */
	session_start();
}

/* Give the $_POST, $_GET, and $_SESSION variables some shorter names */
if(@$_POST) $_p = $_v->sanitize($_POST);
if(@$_GET) $_g = $_v->sanitize($_GET);

@$url = explode('/',$_g['url']);
for($a=0;$a<count($url);$a++) {
	$url[$a] = addslashes($url[$a]);
}
$pagesdir = 'main';
require($protected.'pages/'.$pagesdir.'/startup.php');

if(@$_s->get('err')) {
	$err = $_s->get('err');
	$_s->set('err',FALSE);
}

if(@$_s->get('msg')) {
	$msg = $_s->get('msg');
	$_s->set('msg',FALSE);
}

/* Assign variables for the template */
$smarty->assign('site_name',$site_name);
$smarty->assign('title',$title);
$smarty->assign('pagetitle',$title);
if(isset($title_alt)) $smarty->assign('title_alt',$title_alt);

if(@$msg) $smarty->assign('msg',$msg);
if(@$err) $smarty->assign('err',$err);
if(@$onload) $smarty->assign('onload',$onload);
if(@$_g) $smarty->assign('_g',$_g);
if(@$_p) $smarty->assign('_p',$_p);
if(@$url) $smarty->assign('url',$url);

/* Assign optional variables */
if(@$include) {
	$smarty->assign('include',$pagesdir.'/'.$url[0].'/'.$include);
	if($include=='404') $smarty->assign('include','404/index');
}

/* Tell Smarty if we're working with Dev or Live */
$smarty->assign('dev',$dev);

/* Pull in some variables */
require('variables.php');

/* Now, require some real content! */
if(@!eregi('frame.php',$_SERVER['PHP_SELF']) && @!$ajax) require($protected.'pages/'.$pagesdir.'/index.php');
if(@$ajax) require($protected.'pages/'.$pagesdir.'/ajax.php');

/* Finally attempt to include a shutdown script */
if(@is_file($protected.'pages/'.$pagesdir.'/shutdown.php')) {
	require($protected.'pages/'.$pagesdir.'/shutdown.php');
}
?>
