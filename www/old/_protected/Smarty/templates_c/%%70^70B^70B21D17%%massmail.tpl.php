<?php /* Smarty version 2.6.18, created on 2010-05-11 13:56:37
         compiled from main/admin/massmail.tpl */ ?>
<div class="span-19 last">

	<form method="post">

	<div class="span-19 last">
		<div class="span-4">
			<label for="to">To:</label>
		</div>
		<div class="span-15 last">
			<select name="to" id="to">
				<option value="admin" <?php if ($this->_tpl_vars['_p']['to'] == 'admin'): ?>selected<?php endif; ?>>Admins (For testing)</option>
				<option value="subscribers" <?php if ($this->_tpl_vars['_p']['to'] == 'subscribers'): ?>selected<?php endif; ?>>Subscribers</option>
				<option value="all" <?php if ($this->_tpl_vars['_p']['to'] == 'all'): ?>selected<?php endif; ?>>Everyone (Not recommended)</option>
			</select>
		</div>
	</div>

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['from_name']): ?><div class="span-4">&nbsp;</div><div class="span-15 last err"><?php echo $this->_tpl_vars['err']['from_name']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label for="from_name">From Name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="from_name" id="from_name" size="30" maxlength="50" value="<?php if ($this->_tpl_vars['_p']['from_name']): ?><?php echo $this->_tpl_vars['_p']['from_name']; ?>
<?php else: ?>@ReTweetBot<?php endif; ?>" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['from_address']): ?><div class="span-4">&nbsp;</div><div class="span-15 last err"><?php echo $this->_tpl_vars['err']['from_address']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label for="from_address">From Address:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="from_address" id="from_address" size="30" maxlength="50" value="<?php if ($this->_tpl_vars['_p']['from_address']): ?><?php echo $this->_tpl_vars['_p']['from_address']; ?>
<?php else: ?>info@retweetbot.com<?php endif; ?>" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['subject']): ?><div class="span-4">&nbsp;</div><div class="span-15 last err"><?php echo $this->_tpl_vars['err']['subject']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label for="subject">Subject:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="subject" id="subject" size="30" maxlength="200" value="<?php echo $this->_tpl_vars['_p']['subject']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['message']): ?><div class="span-4">&nbsp;</div><div class="span-15 last err"><?php echo $this->_tpl_vars['err']['message']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label for="message">Message:</label>
		</div>
		<div class="span-15 last">
			<textarea name="message" id="message"><?php echo $this->_tpl_vars['_p']['message']; ?>
</textarea>
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">&nbsp;</div>
		<div class="span-15 last">
			<input type="submit" name="submit" id="submit" value="Send E-mail" />
		</div>
	</div>
	
	</form>
	
</div>