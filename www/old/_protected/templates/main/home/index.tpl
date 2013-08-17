<b>Your Groups</b><br/>
{section name=a loop=$groups}
<a href="{$root}group/{$groups[a].id}">{$groups[a].name}</a><br/>
{sectionelse}
<i>No groups!</i>
{/section}
<br/>
<a href="{$root}group/add">New Group</a>
<br/><br/>
<a href="{$root}logout">Log out</a>