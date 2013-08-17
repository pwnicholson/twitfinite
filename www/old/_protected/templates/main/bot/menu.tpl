<script language="javascript">
var bot_id = {$bot_id};
</script>

<div class="span-19 last">
<div id="navcontainer-hor">
<ul>
<li><a {if $url[0]=='bot' && !$url[2]}class="current"{/if} href="{$root}bot/{$bot_id}">Summary</a></li>
<li><a {if $url[0]=='bot' && $url[2]=='edit'}class="current"{/if} href="{$root}bot/{$bot_id}/edit">Edit Bot/Features</a></li>
<li><a {if $url[0]=='bot' && $url[2]=='userlists'}class="current"{/if} href="{$root}bot/{$bot_id}/userlists">User Lists</a></li>
<li><a {if $url[0]=='bot' && $url[2]=='statistics'}class="current"{/if} href="{$root}bot/{$bot_id}/statistics">Statistics</a></li>
</ul>
</div>
</div>