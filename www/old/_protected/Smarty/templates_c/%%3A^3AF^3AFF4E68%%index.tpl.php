<?php /* Smarty version 2.6.18, created on 2008-12-04 16:06:08
         compiled from main/group/index.tpl */ ?>
<?php echo $this->_tpl_vars['spiffy_start']; ?>

<a href="/retweet">&lt;&lt; Back to groups</a><br/><br/>

<?php if (! $this->_tpl_vars['group']): ?><b>Create a new group</b><br/><?php endif; ?>
<form method="post">
Name: <input type="text" name="name" id="name" value="<?php echo $this->_tpl_vars['group']['name']; ?>
" /><br/>
Twitter E-mail: <input type="text" name="twitter_email" value="<?php echo $this->_tpl_vars['group']['twitter_email']; ?>
" /><br/>
Twitter Screen Name: <input type="text" name="twitter_screenname" value="<?php echo $this->_tpl_vars['group']['twitter_screenname']; ?>
" /><br/>
Twitter Password: <input type="text" name="twitter_password" value="<?php echo $this->_tpl_vars['group']['twitter_password']; ?>
" /><br/>
Show Names: <input type="checkbox" name="show_names" value="1" <?php if ($this->_tpl_vars['group']['show_names'] == 1): ?>checked<?php endif; ?> /><br/>
Retweet Replies: <input type="checkbox" name="use_replies" value="1" <?php if ($this->_tpl_vars['group']['use_replies'] == 1): ?>checked<?php endif; ?> /><br/>
Retweet Direct Messages: <input type="checkbox" name="use_directmessages" value="1" <?php if ($this->_tpl_vars['group']['use_directmessages'] == 1): ?>checked<?php endif; ?> />
<?php if ($this->_tpl_vars['group']): ?><br/><br/>Delete: <input type="checkbox" name="delete" value="Y" /><?php endif; ?>
<br/><br/>
<input type="submit" value="Save" />
</form>
<?php echo $this->_tpl_vars['spiffy_stop']; ?>