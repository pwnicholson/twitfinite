<select name="blacklist" id="blacklist" multiple="true" size="5" style="width: 13em;">
{section name=a loop=$blacklist}
	<option value="{$blacklist[a].twitter_screenname}">{$blacklist[a].twitter_screenname}</option>
{/section}
</select>
{if $blacklist}
<input type="button" id="remove_blacklist" name="remove_blacklist" value="Remove Selected" onclick="RemoveBlacklist(); return false" />
{/if}