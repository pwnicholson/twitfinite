<div class="span-19 last">
	
	<form method="post" action="{$root}admin/movebot">

	<div class="span-19 last">
		{if $err.bot}<div class="span-19 last err">{$err.bot}</div>{/if}
		<div class="span-3">
			<label for="bot">Move Bot:</label>
		</div>
		<div class="span-16 last">
			<select name="bot" id="bot">
				<option value="0">---</option>
			{section name=a loop=$bots}
				<option value="{$bots[a].id}">{$bots[a].twitter_screenname} &mdash; {$bots[a].firstname} {$bots[a].lastname} ({$bots[a].username})</option>
			{/section}
			</select>
		</div>
	</div>
	<div class="span-19 last">
		{if $err.user}<div class="span-19 last err">{$err.user}</div>{/if}
		<div class="span-3">
			<label for="user">To Account:</label>
		</div>
		<div class="span-16 last">
			<select name="user" id="user">
				<option value="0">---</option>
			{section name=a loop=$users}
				<option value="{$users[a].id}">{$users[a].firstname} {$users[a].lastname} ({$users[a].username})</option>
			{/section}
			</select>
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" name="submit1" id="submit1" value="Move Bot" />
		</div>
	</div>
	
	</form>
	
</div>