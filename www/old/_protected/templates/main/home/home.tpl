<div class="span-19 last">
	<div style="float: right; margin-left: 10px; margin-right: 10px; width: 250px; height: 250px;">
		<object width="250" height="250"><param name="movie" value="http://widget.chipin.com/widget/id/dc85a47d8870d352"></param><param name="allowScriptAccess" value="always"></param><param name="wmode" value="transparent"></param><param name="event_title" value="ReTweetBot"></param><param name="event_desc" value="Contribute%20to%20RetweetBot%20and%20keep%20the%20service%20free%21"></param><param name="color_scheme" value="blue"></param><embed src="http://widget.chipin.com/widget/id/dc85a47d8870d352" flashVars="event_title=ReTweetBot&event_desc=Contribute%20to%20RetweetBot%20and%20keep%20the%20service%20free%21&color_scheme=blue" type="application/x-shockwave-flash" allowScriptAccess="always" wmode="transparent" width="250" height="250"></embed></object>
	</div>
	
	<div class="i">Please visit <a href="http://twitter.com/retweetbot" target="twitter">@ReTweetBot</a> on Twitter to see the full list.</div>
	
	<br/>
	
	{section name=a loop=$updates}
	{$updates[a].text}<br/>
	<span class="twitter_ts">{$updates[a].ts}</span>
	<br/>
	{/section}
</div>