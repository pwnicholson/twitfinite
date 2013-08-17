<div class="span-19 last">

	<div class="span-19 last">
		<div class="span-4 b">Full Name</div>
		<div class="span-3 b">Username</div>
		<div class="span-12 b last"># Bots</div>
	</div>
	
	{section name=a loop=$users}
	<div class="span-19 last">
		<div class="span-4"><a href="{$root}retweet/account/{$users[a].id}">{$users[a].firstname} {$users[a].lastname}</a></div>
		<div class="span-3"><a href="{$root}retweet/account/{$users[a].id}">{$users[a].username}</a></div>
		<div class="span-12 last">{$users[a].bot_count}</div>
	</div>
	{/section}

</div>