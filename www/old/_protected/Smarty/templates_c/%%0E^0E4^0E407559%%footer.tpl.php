<?php /* Smarty version 2.6.18, created on 2010-09-19 00:50:52
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'footer.tpl', 18, false),)), $this); ?>
<div id="footer" style="span-24 last">
	<div class="span-24 last">
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home">Home</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/about">About</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/directory">Bot Directory</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/userguide">User Guide</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/adminguide">Admin Guide</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/signup">Sign Up</a> |
		<a href="<?php echo $this->_tpl_vars['root']; ?>
home/contact">Contact Us</a> |
		<A href="<?php echo $this->_tpl_vars['root']; ?>
home/login">Log In</a>
	</div>
	
	<div class="span-24 last i">
		ReTweetBot: A better way to have a conversation!
	</div>
	
	<div class="span-24 last">
		Copyright &copy;<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>

	</div>
</div>