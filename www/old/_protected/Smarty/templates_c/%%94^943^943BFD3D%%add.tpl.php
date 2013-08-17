<?php /* Smarty version 2.6.18, created on 2010-10-31 22:06:59
         compiled from main/bot/add.tpl */ ?>
<div class="container">

<div class="span-19 last">
	
	<form method="post">
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['twitter_screenname']): ?><div class="span-16 last err"><?php echo $this->_tpl_vars['err']['twitter_screenname']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label for="twitter_screenname">Twitter Screen Name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="twitter_screenname" id="twitter_screenname" value="<?php echo $this->_tpl_vars['group']['twitter_screenname']; ?>
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
			<input type="text" name="twitter_email" id="twitter_email" value="<?php echo $this->_tpl_vars['group']['twitter_email']; ?>
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
			<input type="text" name="twitter_password" id="twitter_password" value="<?php echo $this->_tpl_vars['group']['twitter_password']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">&nbsp;</div>
		<div class="span-15 last"><input type="submit" value="Save" />
	</div>
	
	</form>

</div>

</div>