<?php /* Smarty version 2.6.18, created on 2010-09-19 00:51:15
         compiled from main/bot/summary.tpl */ ?>
<div class="container">
	
	<?php if ($this->_tpl_vars['admin'] == 1): ?>
	<div class="span-19 last">
		<div class="span-19 last">
			<span class="b">Owner:</span>
			<?php echo $this->_tpl_vars['bot']['firstname']; ?>
 <?php echo $this->_tpl_vars['bot']['lastname']; ?>
 (<?php echo $this->_tpl_vars['bot']['username']; ?>
)
		</div>
	</div>
	
	<div class="span-19 last"><br/></div>
	<?php endif; ?>
	
	<div class="span-19 last"><h2>General Settings</div>
	
	<div class="span-19 last">
		<div class="span-4">Screen Name:</div>
		<div class="span-5"><a href="http://twitter.com/<?php echo $this->_tpl_vars['bot_settings']['twitter_screenname']; ?>
" target="_blank"><?php echo $this->_tpl_vars['bot_settings']['twitter_screenname']; ?>
</a></div>
		<div class="span-4">E-mail Address:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['twitter_email']; ?>
</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">Listed in Directory:</div>
		<div class="span-5"><?php echo $this->_tpl_vars['bot_settings']['list_in_directory']; ?>
</div>
		<div class="span-4">Bot Description:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['descr']; ?>
</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>ReTweet Settings</h2></div>
	
	<div class="span-19 last">
		<div class="span-4">Show Names:</div>
		<div class="span-5"><?php echo $this->_tpl_vars['bot_settings']['show_names']; ?>
</div>
		<div class="span-4">Username Format:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['username_format']; ?>
</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">Retweet DMs:</div>
		<div class="span-5"><?php echo $this->_tpl_vars['bot_settings']['use_directmessages']; ?>
</div>
		<div class="span-4">Retweet Replies:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['use_replies']; ?>
</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">Retweet Restrictions:</div>
		<div class="span-5">
			<?php if ($this->_tpl_vars['bot_settings']['retweet_restrictions'] == 'a'): ?>
			Admins only
			<?php elseif ($this->_tpl_vars['bot_settings']['retweet_restrictions'] == 'i'): ?>
			Admins and inclusions
			<?php else: ?>
			No restrictions
			<?php endif; ?>
		</div>
		<div clsas="span-9 last">&nbsp;</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>Friends and Followers Settings</div>
	
	<div class="span-19 last">
		<div class="span-4">Auto-follow Followers:</div>
		<div class="span-5">
			<?php echo $this->_tpl_vars['bot_settings']['autofollow']; ?>

			<?php if ($this->_tpl_vars['bot_settings']['autofollow'] == 'Yes'): ?>
			<?php if ($this->_tpl_vars['bot_settings']['follow_cap'] > 0): ?>
			(Capped at <?php echo $this->_tpl_vars['bot_settings']['follow_cap_formatted']; ?>
)
			<?php else: ?>
			(No cap)
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="span-9 last">&nbsp;</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>Filtering</div>
	
	<div class="span-19 last">
		<div class="span-4">Bad Word Filter:</div>
		<div class="span-5">
			<?php if ($this->_tpl_vars['bot_settings']['badwords_filter'] == 'b'): ?>
			Block entire post
			<?php elseif ($this->_tpl_vars['bot_settings']['badwords_filter'] == 'c'): ?>
			Censor word
			<?php elseif ($this->_tpl_vars['bot_settings']['badwords_filter'] == 'd'): ?>
			Delete word
			<?php else: ?>
			No filter
			<?php endif; ?>
		</div>
		<div class="span-4">Use Default Filter:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['use_default_badwords']; ?>
</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">Link Filter:</div>
		<div class="span-5">
		<?php if ($this->_tpl_vars['bot_settings']['link_filter'] == 'b'): ?>
		Block entire post
		<?php elseif ($this->_tpl_vars['bot_settings']['link_filter'] == 'd'): ?>
		Delete link
		<?php else: ?>
		No filter
		<?php endif; ?>
		</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>Hash Tags</h2></div>
	
	<div class="span-19 last">
		<div class="span-4">Auto-append Hash Tags:</div>
		<div class="span-5"><?php echo $this->_tpl_vars['bot_settings']['autoappend_ht']; ?>
</div>
		<div class="span-4">Hash Tags:</div>
		<div class="span-6 last"><?php echo $this->_tpl_vars['bot_settings']['hashtags']; ?>
</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>Twitter Console</h2></div>
	
	<div class="span-19 last">
		<div class="span-4">Enable Confirmation DMs:</div>
		<div class="span-5"><?php echo $this->_tpl_vars['bot_settings']['console_confirm_dm']; ?>
</div>
		<div class="span-4">&nbsp;</div>
		<div class="span-6 last">&nbsp;</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"><h2>Quick Statistics <span class="i note"> - Updated every 2 hours</span></h2></div>
	
	<div class="span-19 last">
		<div class="span-3 b">Updates</div>
		<div class="span-3 b">Tweeters</div>
		<div class="span-3 b">Friends</div>
		<div class="span-3 b">Followers</div>
		<div class="span-7 b last">&nbsp;</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3"><?php echo $this->_tpl_vars['statuses_count']; ?>
</div>
		<div class="span-3"><?php echo $this->_tpl_vars['screenname_count']; ?>
</div>
		<div class="span-3"><?php echo $this->_tpl_vars['friends_count']; ?>
</div>
		<div class="span-3"><?php echo $this->_tpl_vars['followers_count']; ?>
</div>
		<div class="span-7 last">&nbsp;</div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<!-- user lists used to be here -->
	
	
	<div class="span-19 last"><h2>Do Stuff</h2></div>
	<div class="span-19 last">
		<script language="javascript">
		<?php echo '
		function PostUpdate(s) {
			$(\'post_update_response\').style.display = \'block\';
			$(\'post_update_response\').innerHTML = \'Posting...\';
			new Ajax.Updater(\'post_update_response\',root+\'ajax/bot/post_update/\'+bot_id, {
				parameters: {status: $(\'post_update_status\').value}
			});
		}
		'; ?>

		</script>
		<div class="span-3 b">Post update:</div>
		<div class="span-16 last">
			<input type="text" name="post_update_status" id="post_update_status" size="70" maxlength="140" />
			<input type="button" value="Go" id="post_update_submit" name="post_update_submit" onclick="PostUpdate($('post_update_status')); return false" />
		</div>
		<div class="span-3">&nbsp;</div>
		<div class="span-16 b last" id="post_update_response" style="display: none;"></div>
	</div>
	
	
	<div class="span-19 last"><br/></div>
	<div class="span-19 last"><br/></div>
	
	
	<div class="span-19 last"></div>
</div>

<?php echo $this->_tpl_vars['calendar']; ?>