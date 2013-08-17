<select name="include_users" id="include_users" multiple="true" size="5" style="width: 13em;">
{section name=a loop=$include_users}
	<option value="{$include_users[a].twitter_screenname}">{$include_users[a].twitter_screenname}</option>
{/section}
</select>
{if $include_users}
<input type="button" id="include_remove_user" name="include_remove_user" value="Remove Selected" onclick="RemoveIncludeUsers(); return false" />
{/if}