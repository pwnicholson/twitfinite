<?php /* Smarty version 2.6.18, created on 2010-09-19 00:50:57
         compiled from main/home/login.tpl */ ?>
<form method="post" action="<?php echo $this->_tpl_vars['root']; ?>
home/login">

<div class="span-19 last">

	<div class="span-19 last">
		<p>If you have a ReTweetBot.com account, log in here.</p>
	</div>
	
	<?php if ($this->_tpl_vars['err']): ?>
	<div class="span-19 last err">
		<p><?php echo $this->_tpl_vars['err']['fail']; ?>
</p>
	</div>
	<?php endif; ?>

	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="username">Username:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="username" name="username" size="16" value="<?php echo $this->_tpl_vars['_p']['username']; ?>
" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="password">Password:</label>
		</div>
		<div class="span-16 last">
			<input type="password" id="password" name="password" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			&nbsp;
		</div>
		<div class="span-16 last">
			<input type="submit" id="submit" name="submit" value="Submit" />
		</div>
	</div>
	
</div>

</form>