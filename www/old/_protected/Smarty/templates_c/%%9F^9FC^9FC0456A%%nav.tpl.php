<?php /* Smarty version 2.6.18, created on 2010-09-19 00:51:04
         compiled from main/retweet/nav.tpl */ ?>
<ul>
<li><a <?php if (( $this->_tpl_vars['url'][0] == 'retweet' && ! $this->_tpl_vars['url'][1] ) || $this->_tpl_vars['url'][0] == 'bot'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
retweet">My Bots</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'retweet' && $this->_tpl_vars['url'][1] == 'account'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
retweet/account">My Account</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'directory'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/directory">Bot Directory</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'userguide'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/userguide">User Guide</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'adminguide'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/adminguide">Admin Guide</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'contact'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/contact">Contact Us</a></li>
<?php if ($this->_tpl_vars['admin'] == 1): ?>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'admin'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
admin">Admin</a></li>
<?php endif; ?>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'retweet' && $this->_tpl_vars['url'][1] == 'logout'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
logout">Log Out</a></li>
</ul>