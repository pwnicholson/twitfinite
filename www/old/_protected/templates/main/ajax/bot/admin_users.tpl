<select name="admin_users" id="admin_users" multiple="true" size="5" style="width: 13em;">
{section name=a loop=$admin_users}
	<option value="{$admin_users[a].twitter_screenname}">{$admin_users[a].twitter_screenname}</option>
{/section}
</select>
{if $admin_users}
<input type="button" id="admin_remove_user" name="admin_remove_user" value="Remove Selected" onclick="RemoveAdminUsers(); return false" />
{/if}