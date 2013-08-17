<?php /* Smarty version 2.6.18, created on 2010-09-19 01:05:16
         compiled from main/home/contact.tpl */ ?>
<?php if (! $this->_tpl_vars['msg']): ?>

<form method="post" action="<?php echo $this->_tpl_vars['root']; ?>
home/contact">

<div class="span-19 last">

	<div class="span-19 last">
		<p>Use the form below to send us a message.</p>
	</div>

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['firstname']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['firstname']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="firstname">First name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="firstname" name="firstname" size="16" value="<?php echo $this->_tpl_vars['_p']['firstname']; ?>
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
			<input type="text" id="lastname" name="lastname" size="16" value="<?php echo $this->_tpl_vars['_p']['lastname']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['email']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['email']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="email">E-mail address:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="email" name="email" size="16" value="<?php echo $this->_tpl_vars['_p']['email']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['message']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['message']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label class="form_label" for="about_bot">Your message:</label>
		</div>
		<div class="span-16 last">
			<textarea id="message" name="message" rows=5 cols=40><?php echo $this->_tpl_vars['_p']['message']; ?>
</textarea>
		</div>
	</div>

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['captcha']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['captcha']; ?>
</div><?php endif; ?>
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<?php echo $this->_tpl_vars['captcha']; ?>

		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit" name="submit" value="Submit" />
		</div>
	</div>

</div>

</form>

<?php endif; ?>