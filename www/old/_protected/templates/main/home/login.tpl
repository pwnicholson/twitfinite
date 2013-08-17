<form method="post" action="{$root}home/login">

<div class="span-19 last">

	<div class="span-19 last">
		<p>If you have a ReTweetBot.com account, log in here.</p>
	</div>
	
	{if $err}
	<div class="span-19 last err">
		<p>{$err.fail}</p>
	</div>
	{/if}

	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="username">Username:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="username" name="username" size="16" value="{$_p.username}" />
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