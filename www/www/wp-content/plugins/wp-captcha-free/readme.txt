=== WP Captcha-Free ===
Contributors: iDope
Donate link: http://efextra.com/
Tags: spam, antispam, anti-spam, comments, comment, captcha, hash, token,tbt,ajax
Requires at least: 2.3
Tested up to: 3.4.1
Stable tag: trunk

WP Captcha-Free is a lightweight plugin that blocks automated comment spam without using captcha (image verfication).

== Description ==

WP Captcha-Free blocks automated comment spam without resorting to CAPTCHAs. It does so by validating a hash based on time (and some other parameters) using AJAX when the form is posted. Comments posted via automated means will not have a hash or will have an expired hash and will be rejected. Unlike using a captcha, this does not place any burden on the commenter.

= Features =

1. Ensures that your commenters are human without inconviencing them with CAPTCHAs, challenge questions, etc.
2. The plugin is very simple and adds almost zero overhead. You will notice its presence only by the absence of spam.
3. Use of AJAX makes it compatible with all cache plugins (including WP-Cache) and adds another layer of security.
4. Works out of the box without any configuration, setup, or editing .php files.

= How It Works =

WP Captcha-Free generates a hash (aka token) based on several parameters like time (with a some cushion), post id, IP address, and browser user-agent which should not change between requests (within a short period of say a few seconds). When the comment form is posted the plugin uses ajax to get a hash value and adds it to a hidden field. On the server side it verifies if the hash is valid or not. It uses adds random salt to the hash so that it cannot be guessed.

A combination of a time based hash and javascript (ajax) makes it almost impossible for any bot to bypass.

= Feedback =

Please let me know what you think about the plugin and any suggestions you may have. If you use the plugin please rate it. If it doesn't work for you do let me know so I can fix it.

[Post Feedback](http://wordpress.org/tags/wp-captcha-free?forum_id=10#postform "Post your feedback, suggestions or bug reports")

== Installation ==

1. Upload `captcha-free.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it! WP Captcha-Free will start blocking automated comment spam behind the scenes

Note: If your WordPress theme doesn't have the comment_form hook, enter the following code right before the closing `</form>` tag in the `comments.php` file of the theme.

`<?php do_action('comment_form', $post->ID); ?>`


== Frequently Asked Questions ==

= How does WP Captcha-Free work? =

WP Captcha-Free generates a hash (aka token) based on several parameters like time (with a cushion of about 1 hour), post id, IP address, and browser user-agent which should not change between requests. When the comment form is posted the plugin uses ajax to get a hash value and adds it to a hidden field. On the server side it verifies if the hash is valid or not. It uses adds random salt to the hash so that it cannot be guessed.

= Is WP Captcha-Free better than Akismet? =

That is not a proper comparison. Akismet blocks comment spam by analyzing its content while WP Captcha-Free does so by checking how it was submitted. I would suggest using WP Captcha-Free in conjunction with Akismet for best results.

= Is JavaScript required to comment? =

Yes, WP Captcha-Free uses JavaScript/AJAX to add another layer of security and to make it compatible with caching plugins like WP-Cache.

= Are Cookies required to comment? =

No, WP Captcha-Free does not use cookies.

= What happens with pingbacks and trackbacks? =

WP Captcha-Free does not filter pingbacks and trackbacks.

= Can you add a feature X? =

Let me know, I will try if its useful enough and I have time for it.

== Changelog ==

= 0.9 =
* Better way to find the comment form (fixes the 'Invalid data' error reported by some users).

= 0.8 =
* Added options page.

= 0.7 =
* Fixed bug introduced in the last update.

= 0.6 =
* Bypass spam check for logged-in users (except users with the 'subscriber' role)
* Tested upto Wordpress 2.8

= 0.5 =
* Bug Fixes (Now it should work from any folder)
* Tested upto Wordpress 2.7 
