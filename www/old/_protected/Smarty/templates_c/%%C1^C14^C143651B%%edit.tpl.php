<?php /* Smarty version 2.6.18, created on 2010-09-19 16:23:38
         compiled from main/bot/edit.tpl */ ?>
<form method="post">

<div class="span-19 last">
<h3>Authorization Settings</h3>
</div>

<?php if ($this->_tpl_vars['bot']['oauth_token'] == '' && $this->_tpl_vars['bot']['oauth_secret'] == ''): ?>
<div class="span-19 last">
	<div class="span-19 last">
		<p>You can now register your bot with Twitter's new authorization scheme.  Your username, e-mail address, and password
		are no longer required to use your bot with ReTweetBot.  This type of authorization will be required for every Twitter
		application as of July 1st 2010.  In order to make the transition yourself, make sure you are signed in to Twitter with your bot
		account and then click the button below.</p>
	</div>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['bot']['oauth_token'] != '' && $this->_tpl_vars['bot']['oauth_secret'] != ''): ?>
<div class="span-19 last">
	<p>Your account is registered using Twitter's new OAuth method.  If something isn't working, click the button below.  If you
	are still experiencing problems, <a href="/home/contact">contact us</a>.</p>

	<p>Please note that Twitter will ask for you to grant access to the "Twitfinite" application.  This is due to a prior application
	named "ReTweetBot" being already registered in Twitter's system (even though we were there first using the original system.  Do not
	be alarmed.  It's still the same couple of guys you've grown to love (or be really frustrated with at times!).  ;-)</p>
</div>
<input type="hidden" name="oauth" value="true" />
<?php endif; ?>

<div class="span-19 last">
	<a href="http://oauth.twitfinite.com"><img src="/images/lighter.png" /></a>
</div>

<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
<h3>General Settings</h3>
</div>


<?php if ($this->_tpl_vars['bot']['oauth_token'] == '' && $this->_tpl_vars['bot']['oauth_secret'] == ''): ?>
<div class="span-19 last">
	<?php if ($this->_tpl_vars['err']['twitter_screenname']): ?><div class="span-16 last err"><?php echo $this->_tpl_vars['err']['twitter_screenname']; ?>
</div><?php endif; ?>
	<div class="span-4">
		<label for="twitter_screenname">Twitter Screen Name:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="twitter_screenname" id="twitter_screenname" value="<?php echo $this->_tpl_vars['bot']['twitter_screenname']; ?>
" />
	</div>
</div>

<div class="span-19 last">
	<?php if ($this->_tpl_vars['err']['twitter_email']): ?><div class="span-16 last err"><?php echo $this->_tpl_vars['err']['twitter_email']; ?>
</div><?php endif; ?>
	<div class="span-4">
		<label for="twitter_email">Twitter E-mail:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="twitter_email" id="twitter_email" value="<?php echo $this->_tpl_vars['bot']['twitter_email']; ?>
" />
	</div>
</div>

<div class="span-19 last">
	<?php if ($this->_tpl_vars['err']['twitter_password']): ?><div class="span-16 last err"><?php echo $this->_tpl_vars['err']['twitter_password']; ?>
</div><?php endif; ?>
	<div class="span-4">
		<label for="twitter_password">Twitter Password:</label>
	</div>
	<div class="span-15 last">
		<input type="password" name="twitter_password" id="twitter_password" value="<?php echo $this->_tpl_vars['bot']['twitter_password']; ?>
" />
	</div>
</div>
<?php endif; ?>

<div class="span-19 last">
	<div class="span-4">
		<label for="descr">Bot Description:</label>
	</div>
	<div class="span-15 last">
		<textarea name="descr" id="descr" style="width: 30em; height: 5em; margin: 0px; margin-top: 1px; padding: 2px;"><?php echo $this->_tpl_vars['bot']['descr']; ?>
</textarea>
		<div class="i">This description is used in the bot directory listing.  If you do not include a description, your bot will not be listed.</span>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="list_in_directory">List in Directory:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="list_in_directory" id="list_in_directory" value="1" <?php if ($this->_tpl_vars['bot']['list_in_directory'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>



<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>ReTweet Settings</h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="show_names">Show Names:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="show_names" id="show_names" value="1" <?php if ($this->_tpl_vars['bot']['show_names'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="username_format">Username Format:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="username_format" id="username_format" value="<?php echo $this->_tpl_vars['bot']['username_format']; ?>
" />
		<span class="i">
			Default is "%%username%%:".<br/>
			Use %%username%% where you would like the user's Twitter screenname to be.
		</span>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="use_replies">Retweet Replies:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="use_replies" id="use_replies" value="1" <?php if ($this->_tpl_vars['bot']['use_replies'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="use_directmessages">Retweet Direct Messages:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="use_directmessages" id="use_directmessages" value="1" <?php if ($this->_tpl_vars['bot']['use_directmessages'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="retweet_restrictions">Retweet Restrictions:</label>
	</div>
	<div class="span-15 last">
		<select name="retweet_restrictions" id="retweet_restrictions">
			<option value="0" <?php if ($this->_tpl_vars['bot']['retweet_restrictions'] == ''): ?>selected<?php endif; ?>>No restrictions</option>
			<option value="a" <?php if ($this->_tpl_vars['bot']['retweet_restrictions'] == 'a'): ?>selected<?php endif; ?>>Admins only</option>
			<option value="i" <?php if ($this->_tpl_vars['bot']['retweet_restrictions'] == 'i'): ?>selected<?php endif; ?>>Admins and inclusions</option>
		</select>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="autosplit_enabled">Enable Auto-split:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="autosplit_enabled" id="autosplit_enabled" <?php if ($this->_tpl_vars['bot']['autosplit_enabled'] == 1): ?>checked<?php endif; ?> /><br/>
		<span class="i">
			By default, Twitter will reject any tweets over 140 characters. To get around this limitation, we have come up with an auto-split
			feature that will automagically break up longer, individual tweets into multiple, shorter tweets.
		</span>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="autosplit_delimiter">Auto-split delimiter:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="autosplit_delimiter" id="autosplit_delimiter" value="<?php echo $this->_tpl_vars['bot']['autosplit_delimiter']; ?>
"/><br/>
		<span class="i">
			This is the delimiter used at the end of long tweets that will indicate that it is a multiple.  Use %x for the current tweet
			number and %X for the total number of tweets.  For example, "... (%x/%X)" will produce "... (1/2)" at the end of the tweet.
		</span>
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Anonymizer Settings</h3>
</div>

<div class="span-19 last">
	<span class="i">
		This feature will allow your users to post anonymously but still keep a pseudo-identity.  Please note that in order to allow this,
		the anonymous feature is not 100% anonymous as we do have to keep track of the user's Twitter ID number to maintain the pseudo-identities.
		We do our absolute best to make sure this will remain as anonymous as humanly and technically possible.  We take no responsibility with
		how you or your user's use this feature and cannot be held liable for any breaches of privacy that you or your users may expect.  Use this
		feature at your own risk and make sure your users are aware of this fact.
	</span>
</div>

<div class="span-19 last"><br/></div>

<div class="span-19 last">
	<div class="span-4">
		<label for="enable_anonymous">Enable Anonymizer:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="enable_anonymous" id="enable_anonymous" value="1" <?php if ($this->_tpl_vars['bot']['enable_anonymous'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="anonymous_username_prepend">Username Pre-pend:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="anonymous_username_prepend" id="anonymous_username_prepend" value="<?php echo $this->_tpl_vars['bot']['anonymous_username_prepend']; ?>
" /><br/>
		<span class="i">This is what will be prepended to the anonymous username number (e.g. "U1234")</span>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="anonymous_username_format">Username Format:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="anonymous_username_format" id="anonymous_username_format" value="<?php echo $this->_tpl_vars['bot']['anonymous_username_format']; ?>
" /><br/>
		<span class="i">Use "%s" for the username and "%d" (in the form of <a href="http://www.php.net/sprintf">PHP's sprintf() function</a>) for the number.</span>
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Friends and Followers</h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="autofollow">Auto-follow Followers:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="autofollow" id="autofollow" value="1" <?php if ($this->_tpl_vars['bot']['autofollow'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="follow_cap">Friends' Follower Cap:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="follow_cap" id="follow_cap" value="<?php echo $this->_tpl_vars['bot']['follow_cap']; ?>
" />
	</div>
	<div class="span-4">&nbsp;</div>
	<div class="span-15 last i">
		To try and limit the number of SPAM bots you follow, set the auto-follow friends' follower cap here.
		See the admin guide for more information.
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Filtering</h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="badwords_filter">Bad Word Filter:</label>
	</div>
	<div class="span-15 last">
		<select name="badwords_filter" id="badwords_filter">
			<option value="0" <?php if ($this->_tpl_vars['bot']['badwords_filter'] == ''): ?>selected<?php endif; ?>>No filter</option>
			<option value="c" <?php if ($this->_tpl_vars['bot']['badwords_filter'] == 'c'): ?>selected<?php endif; ?>>Censor word ("blah" becomes "b**h")</option>
			<option value="b" <?php if ($this->_tpl_vars['bot']['badwords_filter'] == 'b'): ?>selected<?php endif; ?>>Block entire post</option>
			<option value="d" <?php if ($this->_tpl_vars['bot']['badwords_filter'] == 'd'): ?>selected<?php endif; ?>>Delete word</option>
		</select>
	</div>
</div>

<div class="span-19 last">	
	<div class="span-4">
		<label for="use_default_badwords">Use Default Filter:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="use_default_badwords" id="use_default_badwords" value="1" <?php if ($this->_tpl_vars['bot']['use_default_badwords'] == 1): ?>checked<?php endif; ?> />
		<span class="i">This is a list of bad words/curse words that we have already prepared.  You can add your own custom words to filter for as well.  Add custom words under the User Lists section.</span>
	</div>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="link_filter">Link Filter:</label>
	</div>
	<div class="span-15 last">
		<select name="link_filter" id="link_filter">
			<option value="0" <?php if ($this->_tpl_vars['bot']['link_filter'] == ''): ?>selected<?php endif; ?>>No filter</option>
			<option value="d" <?php if ($this->_tpl_vars['bot']['link_filter'] == 'd'): ?>selected<?php endif; ?>>Delete link</option>
			<option value="b" <?php if ($this->_tpl_vars['bot']['link_filter'] == 'b'): ?>selected<?php endif; ?>>Block entire post</option>
		</select>
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Hash Tags</h3></h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="autoappend_ht">Auto-append Hash Tags:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="autoappend_ht" id="autoappend_ht" value="1" <?php if ($this->_tpl_vars['bot']['autoappend_ht'] == 1): ?>checked<?php endif; ?> />
	</div>
	
	<div class="span-4">
		<label for="hashtags">Hash tags:</label>
	</div>
	<div class="span-15 last">
		<input type="text" name="hashtags" id="hashtags" value="<?php echo $this->_tpl_vars['bot']['hashtags']; ?>
" />
	</div>
	
	<div class="span-4">&nbsp;</div>
	<div class="span-15 last i">
		Put your hash tags here (including the #) in the priority you wish for them to be used.  Separate with spaces.
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Twitter Console</h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="console_confirm_dm">Enable Confirmation DMs:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" id="console_confirm_dm" name="console_confirm_dm" value="1" <?php if ($this->_tpl_vars['bot']['console_confirm_dm'] == 1): ?>checked<?php endif; ?> />
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<h3>Disable</h3>
</div>

<div class="span-19 last">
	<div class="span-4">
		<label for="disabled">Disable:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="disabled" id="disabled" value="1" <?php if ($this->_tpl_vars['bot']['disabled'] == 1): ?>checked<?php endif; ?> />
		<span class="i">This will disable your bot and prevent it from checking for updates.  You can re-enable your bot later.</span>
	</div>
</div>

<script language="javascript">
<?php echo '
function doDeleteConfirm() {
	if($(\'delete\').checked) {
		return confirm("Are you absolutely sure you want to do this?\\nThis cannot be undone!\\nClick OK for yes, Cancel for No.");
	}
}
'; ?>

</script>

<div class="span-19 last">
	<div class="span-4">
		<label for="delete">Delete:</label>
	</div>
	<div class="span-15 last">
		<input type="checkbox" name="delete" id="delete" value="Y" onclick="return doDeleteConfirm();" />
		<span class="i">There's no turning back on this one.  Once you delete your bot, all settings and statistics will be lost!</span>
	</div>
</div>


<div class="span-19 last"><br/><br/></div>

<div class="span-19 last">
	<div class="span-4">&nbsp;</div>
	<div class="span-15 last"><input type="submit" value="Save" /></div>
</div>

</form>