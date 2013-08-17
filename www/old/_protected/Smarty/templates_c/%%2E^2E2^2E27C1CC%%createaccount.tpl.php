<?php /* Smarty version 2.6.18, created on 2010-09-26 12:11:07
         compiled from main/admin/createaccount.tpl */ ?>
<div class="span-19 last">
	
	<form method="post" action="<?php echo $this->_tpl_vars['root']; ?>
admin/createaccount">

	<div class="span-19 last">
	<?php if ($this->_tpl_vars['err']['firstname']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['firstname']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label class="form_label" for="firstname">First name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="firstname" id="firstname" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['lastname']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['lastname']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label class="form_label" for="lastname">Last name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="lastname" id="lastname" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['email']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['email']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label class="form_label" for="email">E-mail:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="email" id="email" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['username']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['username']; ?>
</div><?php endif; ?>
		<div class="span-4">
			<label class="form_label" for="username">Username:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="username" id="username" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
	
		<div class="span-10 last">
			<div class="span-10 last">
				<?php if ($this->_tpl_vars['err']['password']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['password']; ?>
</div><?php endif; ?>
				<div class="span-4">
					<label class="form_label" for="password">Password:</label>
				</div>
				<div class="span-6 last">
					<input type="password" name="password" id="password" size="16" />
				</div>
			</div>
			
			<div class="span-10 last">
				<div class="span-4">
					<label class="form_label" for="confirm">Confirm:</label>
				</div>
				<div class="span-6 last">
					<input type="password" name="confirm" id="confirm" size="16" />
				</div>
			</div>
		</div>
		
		<div class="span-9 last">
			<script language="javascript">
			<?php echo '
			function doPWGen() {
				new Ajax.Updater(\'pwgen\',root+\'ajax/admin/pwgen\', {
					onSuccess: function(transport) {
						pw = transport.responseText;
						pw = pw.replace("<!-- Begin AJAX -->","");
						pw = pw.replace("<!-- End AJAX -->","");
						pw = pw.trim();
						$(\'pwgen\').value = pw;
					} }
				)
			}
			'; ?>

			</script>
			<input type="button" value="Generate Password" onclick="doPWGen();"/><br/>
			<div id="pwgen"></div>
		</div>
	
	</div>
	
	<div class="span-19 last">
		<div class="span-4">
			<label for="send_email">Send E-mail?</label>
		</div>
		<div class="span-15 last">
			<input type="checkbox" name="send_email" id="send_email" value="Y" checked />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">
			<label for="admin">Is admin?</label>
		</div>
		<div class="span-15 last">
			<input type="checkbox" name="admin" id="admin" value="Y" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">&nbsp;</div>
		<div class="span-15 last">
			<input type="submit" name="submit1" id="submit1" value="Create Account" />
		</div>
	</div>
	
	</form>
</div>