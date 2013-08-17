<a href="{$root}">&lt;&lt; Back to groups</a><br/><br/>

{if !$group}<b>Create a new group</b><br/>{/if}
<form method="post">
Name: <input type="text" name="name" id="name" value="{$group.name}" /><br/>
Twitter E-mail: <input type="text" name="twitter_email" value="{$group.twitter_email}" /><br/>
Twitter Screen Name: <input type="text" name="twitter_screenname" value="{$group.twitter_screenname}" /><br/>
Twitter Password: <input type="text" name="twitter_password" value="{$group.twitter_password}" /><br/>
Show Names: <input type="checkbox" name="show_names" value="1" {if $group.show_names==1}checked{/if} /><br/>
Retweet Replies: <input type="checkbox" name="use_replies" value="1" {if $group.use_replies==1}checked{/if} /><br/>
Retweet Direct Messages: <input type="checkbox" name="use_directmessages" value="1" {if $group.use_directmessages==1}checked{/if} />
{if $group}<br/><br/>Delete: <input type="checkbox" name="delete" value="Y" />{/if}
<br/><br/>
<input type="submit" value="Save" />
</form>
