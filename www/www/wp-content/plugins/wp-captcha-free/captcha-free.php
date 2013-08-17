<?php
/*
Plugin Name: WP Captcha Free
Plugin URI: http://blinger.org/wordpress-plugins/captcha-free/
Description: Block comment spam without captcha.
Author: iDope
Version: 0.9.1
Author URI: http://efextra.com/
*/

/*  Copyright 2008  Saurabh Gupta  (email : saurabh0@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// are we inside wp?
if(!defined('ABSPATH')) {
	// check if this is an ajax post
	if(isset($_POST['post_id'])) {
		// find wp-config.php
		if(file_exists('../../wp-config.php')) {
			$includefile='../../wp-config.php';
		} else if(file_exists('../../../wp-config.php')) {
			$includefile='../../../wp-config.php';
		} else {
			die('alert("Unable to include wp-config.php. Please make sure \'captcha-free.php\' is uploaded to the \'wp-content/plugins/\' folder.")');
		}
		// load wordpress
		require_once($includefile);
		nocache_headers();
		$post_id = intval($_POST['post_id']);
		$timehash=timehash($post_id,time());
	    echo "gothash('$timehash')";
	}
	exit;
}

// generate random salt on activation
register_activation_hook(__FILE__,'cf_make_salt');
function cf_make_salt() {
	update_option('cf_salt',mt_rand());
}

add_action('init', 'cf_init');
function cf_init() {
	// Bypass check for logged in users (except 'subscriber')
	if(!current_user_can('level_1')) {
		add_action('wp_head', 'cf_js_header' );
		add_action('comment_form', 'cf_comment_form', 10);
		add_action('preprocess_comment', 'cf_comment_post');
	}
	// Hook for adding admin menus
	add_action('admin_menu', 'cf_admin_menu');
}

// add javascripts
function cf_js_header() {
	wp_print_scripts( array( 'sack' ));
}

// admin menu
function cf_admin_menu() {
	add_options_page('WP Captcha-Free', 'WP Captcha-Free', 'manage_options', 'wp_cf', 'cf_options_page');
}

function cf_options_page() {
	if(isset($_POST['cf_save'])) {
		$cf_poweredby = isset($_POST['cf_poweredby']) ? 'yes' : 'no';
		update_option('cf_poweredby', $cf_poweredby);
		echo "<div id='message' class='updated fade'><p>Options saved.</p></div>";
	}
?>
	<div class="wrap"><h2>WP Captcha-Free Options</h2>
	<form name="cf_form" action="" method="post" id="cf_form">
	<label for="cf_poweredby" class="selectit"><input type="checkbox" tabindex="1" id="cf_poweredby" name="cf_poweredby" value="yes" <?php if(get_option('cf_poweredby')=='yes') echo 'checked="checked"'; ?> /> Show WP Captcha-Free link on the comment forms</label><br />
	<p class="submit">
	<input name="cf_save" type="submit" id="cf_save" tabindex="2" style="font-weight: bold;" value="Save Options" />
	</p>	
	</form>
	</div>
<?php	
}
// add hidden field for hash and ajax stuff to the form
function cf_comment_form($post_id) {
	?>
<input type="hidden" id="captchafree" name="captchafree" value="" />
<script type="text/javascript">
//<![CDATA[
	function gethash(){
		document.getElementById('captchafree').form.onsubmit = null;
		if(document.getElementById('submit')) document.getElementById('submit').value='Please wait...';
		var mysack = new sack("<?php echo get_option('siteurl').cf_get_path().'captcha-free.php'; ?>");
		mysack.execute = 1;
		mysack.method = 'POST';
		mysack.onError = function() { alert('Unable to get Captcha-Free Hash!') };
		mysack.setVar('post_id', <?php echo $post_id; ?>);
		mysack.runAJAX();
		return false;
	}
	function gothash(myhash){
		document.getElementById('captchafree').value = myhash;
		// Workaround for Wordpress' retarded choice of naming the submit button same as a JS function name >:-(
		document.getElementById('submit').click();
	}
	document.getElementById('captchafree').form.onsubmit = gethash;
//]]>
</script>
<noscript><p><strong>Please note:</strong> JavaScript is required to post comments.</p></noscript>
<?php
	if(get_option('cf_poweredby')=='yes')
		echo '<p style="font-size: small"><a href="http://wordpresssupplies.com/wordpress-plugins/captcha-free/">Spam protection by WP Captcha-Free</a></p>';
}

// Validate the hash
function cf_comment_post($commentdata) {
	// Ignore trackbacks
	if($commentdata['comment_type']!='trackback') {
		// Calculate the timehash that is valid now
		$timehash=timehash($commentdata['comment_post_ID'],time());
		// Calculate the timehash that was valid 1 hour back to give some cushion
		$timehash_old=timehash($commentdata['comment_post_ID'],time()-3600);
		if($_POST['captchafree']!=$timehash && $_POST['captchafree']!=$timehash_old)
			wp_die('Invalid Data: Please go back and try again.');
	}
	return $commentdata;
}

// generate a hash for a given post and timestamp
function timehash ($post_id,$timestamp) {
	// Make a hash out of stuff that shouldn't change between requests
	return md5(get_option('cf_salt').$post_id.date('yzH',$timestamp).$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
}

// Get virtual path to this plugin
function cf_get_path() {
	$rootpath = preg_replace('|\\\\+|','/',ABSPATH); // Cater for Windows paths
	$rootpath = untrailingslashit($rootpath); // Remove trailing slash if exists
	$mypath = preg_replace('|\\\\+|','/',dirname(__FILE__));
	$mypath = str_replace($rootpath,'',$mypath); // just get the virtual path
	$mypath = trailingslashit($mypath); // Add trailing slash
	return $mypath;
}
?>
