<div class="span-19 last">
	<div class="span-19 last">
		Here is the current directory listing of all bots powered by ReTweetBot.com.  Feel free to peruse the bots
		and see if there are any that you might find interesting.
	</div>
	
	<div class="span-19 last"><br/></div>

	{section name=a loop=$directory}
	<div class="span-19 last">
		<div class="span-19 last"><h2><a href="http://twitter.com/{$directory[a].twitter_screenname}" target="_blank">@{$directory[a].twitter_screenname}</a></h2></div>
		<div class="span-19 last">
		{if $directory[a].descr}
			{$directory[a].descr}
		{else}
			There is no description for this bot.
		{/if}
		</div>
		<div class="span-19 last"><br/><br/></div>
	</div>
	{sectionelse}
	<div class="span-19 last i">None</div>
	{/section}
</div>