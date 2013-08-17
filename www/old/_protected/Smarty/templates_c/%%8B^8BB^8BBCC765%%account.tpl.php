<?php /* Smarty version 2.6.18, created on 2010-09-19 17:48:21
         compiled from main/retweet/account.tpl */ ?>
<form method="post" action="<?php echo $this->_tpl_vars['root']; ?>
retweet/account<?php if ($this->_tpl_vars['admin'] == 1 && $this->_tpl_vars['url'][2]): ?>/<?php echo $this->_tpl_vars['url'][2]; ?>
<?php endif; ?>">

<div class="span-19 last">
	<?php if ($this->_tpl_vars['msg']['account']): ?><div class="span-19 last msg"><?php echo $this->_tpl_vars['msg']['account']; ?>
</div><?php endif; ?>

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['username']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['username']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="username">User name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="username" name="username" size="16" value="<?php echo $this->_tpl_vars['user']['username']; ?>
" disabled="true" />
		</div>
	</div>

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['firstname']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['firstname']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="firstname">First name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="firstname" name="firstname" size="16" value="<?php echo $this->_tpl_vars['user']['firstname']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['lastname']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['lastname']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="lastname">Last name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="lastname" name="lastname" size="16" value="<?php echo $this->_tpl_vars['user']['lastname']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['email']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['email']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="email">E-mail Address:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="email" name="email" size="16" value="<?php echo $this->_tpl_vars['user']['email']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="admin">Get E-mail Updates:</label>
		</div>
		<div class="span-16 last">
			<input type="checkbox" id="newsletter" name="newsletter" value="Y" <?php if ($this->_tpl_vars['user']['newsletter'] == 1): ?>checked="true"<?php endif; ?>/>
		</div>
	</div>
	
	<?php if ($this->_tpl_vars['admin'] == 1): ?>
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="admin">Admin:</label>
		</div>
		<div class="span-16 last">
			<input type="checkbox" id="admin" name="admin" value="Y" <?php if ($this->_tpl_vars['user']['admin'] == 1): ?>checked="true"<?php endif; ?>/>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit1" name="submit" value="Submit" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-19 last b">
			<br/>
			Reset Password
		</div>
		<?php if ($this->_tpl_vars['err']['password']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['password']; ?>
</div><?php endif; ?>
		<?php if ($this->_tpl_vars['msg']['password']): ?><div class="span-19 last msg"><?php echo $this->_tpl_vars['msg']['password']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="password1">New Password:</label>
		</div>
		<div class="span-16 last">
			<input type="password" id="password1" name="password1" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="password2">Confirm:</label>
		</div>
		<div class="span-16 last">
			<input type="password" id="password2" name="password2" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit2" name="submit" value="Submit" />
		</div>
	</div>
	
</div>

</form>