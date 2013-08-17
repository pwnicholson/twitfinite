<select name="badwords" id="badwords" multiple="true" size="5" style="width: 13em;">
{section name=a loop=$badwords}
	<option value="{$badwords[a].badword}">{$badwords[a].badword}</option>
{/section}
</select>
{if $badwords}
<input type="button" id="remove_badword" name="remove_badword" value="Remove Selected" onclick="RemoveBadWords(); return false" />
{/if}