<div class="container">

<div class="span-19 last">
	
	<form method="post">
	
	<div class="span-19 last">
		{if $err.twitter_screenname}<div class="span-16 last err">{$err.twitter_screenname}</div>{/if}
		<div class="span-4">
			<label for="twitter_screenname">Twitter Screen Name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="twitter_screenname" id="twitter_screenname" value="{$group.twitter_screenname}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.twitter_email}<div class="span-16 last err">{$err.twitter_email}</div>{/if}
		<div class="span-4">
			<label for="twitter_email">Twitter E-mail:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="twitter_email" id="twitter_email" value="{$group.twitter_email}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.twitter_password}<div class="span-16 last err">{$err.twitter_password}</div>{/if}
		<div class="span-4">
			<label for="twitter_password">Twitter Password:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="twitter_password" id="twitter_password" value="{$group.twitter_password}" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">&nbsp;</div>
		<div class="span-15 last"><input type="submit" value="Save" />
	</div>
	
	</form>

</div>

</div>