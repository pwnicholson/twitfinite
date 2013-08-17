<?php /* Smarty version 2.6.18, created on 2010-09-19 00:50:52
         compiled from main/home/nav.tpl */ ?>
<ul>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && ! $this->_tpl_vars['url'][1]): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home">Home</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'about'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/about">About</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'directory'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/directory">Bot Directory</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'userguide'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/userguide">User Guide</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'adminguide'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/adminguide">Admin Guide</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'signup'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/signup">Sign Up</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'contact'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/contact">Contact Us</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'home' && $this->_tpl_vars['url'][1] == 'login'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
home/login">Log In</a></li>
</ul>