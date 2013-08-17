
<div class="container">
	<div class="span-19 last">
		<div class="span-4 b">Bot Name</div>
		<div class="span-3 b">Updates</div>
		<div class="span-3 b">Tweeters</div>
		<div class="span-3 b">Friends</div>
		<div class="span-3 b">Followers</div>
		<div class="span-3 b last">&nbsp;</div>
	</div>
{section name=a loop=$groups}
	<div class="span-19 last">
		<div class="span-4"><a href="{$root}bot/{$groups[a].group_id}">{$groups[a].twitter_screenname}</a></div>
		<div class="span-3">{$groups[a].statuses_count|default:0}</div>
		<div class="span-3">{$groups[a].screenname_count|default:0}</div>
		<div class="span-3">{$groups[a].friends_count|default:0}</div>
		<div class="span-3">{$groups[a].followers_count|default:0}</div>
		<div class="span-3 last">&nbsp;</div>
	</div>
{sectionelse}
		<div class="span-19 last"><i>No bots!</i></div>
{/section}
	<div class="span-19 last">&nbsp;</div>
	<div class="span-19 last"><a href="{$root}bot/add">+ New Bot</a></div>
</div>