<div class="span-19 last"><h2>Admin Users</h2></div>
<div class="span-19 last i">This will allow the specified users to send commands over Twitter to your bot.</div>
<script language="javascript">
{literal}
function UpdateAdminUsers() {
	new Ajax.Updater('admin_users_dropdown',root+'ajax/bot/admin_users/'+bot_id)
}

function AddAdminUser(s) {
	new Ajax.Updater('admin_users_dropdown',root+'ajax/bot/admin_users/'+bot_id, {
		method: 'post',
		parameters: { twitter_screenname: $('admin_user_add').value }
	});
	$('admin_user_add').value = '';
}

function RemoveAdminUsers() {
	e = $('admin_users');
	s = ''
	for(var i=0; i<e.options.length; i++) {
		if(e.options[i].selected) {
			s += '|'+e.options[i].value+'|'
		}
	}
	new Ajax.Updater('admin_users_dropdown',root+'ajax/bot/admin_users/'+bot_id, {
		method: 'post',
		parameters: { remove_screenname: s }
	});
}

UpdateAdminUsers();
{/literal}
</script>
<div class="span-19 last">
	<div class="span-3 b">Admin Users:</div>
	<div class="span-5" id="admin_users_dropdown">&nbsp;</div>
	<div class="span-11 last b">
		Add User:
		<input type="text" id="admin_user_add" name="admin_user_add" size="10" maxlength="20" />
		<input type="button" id="admin_user_submit" name="admin_user_submit" value="Add" onclick="AddAdminUser(this.value); return false" />
	</div>
</div>


{if $bot_settings.retweet_restrictions=='i'}
<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last"><h2>Included Users</h2></div>
<div class="span-19 last i">If you have any retweet restrictions on your bot, this is where you include users</div>
<script language="javascript">
{literal}
function UpdateIncludeUsers() {
	new Ajax.Updater('include_users_dropdown',root+'ajax/bot/include_users/'+bot_id)
}

function AddIncludeUser(s) {
	new Ajax.Updater('include_users_dropdown',root+'ajax/bot/include_users/'+bot_id, {
		method: 'post',
		parameters: { twitter_screenname: $('include_user_add').value }
	});
	$('include_user_add').value = '';
}

function RemoveIncludeUsers() {
	e = $('include_users');
	s = ''
	for(var i=0; i<e.options.length; i++) {
		if(e.options[i].selected) {
			s += '|'+e.options[i].value+'|'
		}
	}
	new Ajax.Updater('include_users_dropdown',root+'ajax/bot/include_users/'+bot_id, {
		method: 'post',
		parameters: { remove_screenname: s }
	});
}

UpdateIncludeUsers();
{/literal}
</script>
<div class="span-19 last">
	<div class="span-3 b">Include Users:</div>
	<div class="span-5" id="include_users_dropdown">&nbsp;</div>
	<div class="span-11 last b">
		Add User:
		<input type="text" id="include_user_add" name="include_user_add" size="10" maxlength="20" />
		<input type="button" id="include_user_submit" name="include_user_submit" value="Add" onclick="AddIncludeUser(this.value); return false" />
	</div>
</div>
{/if}


{if $bot_settings.badwords_filter!=''}
<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last"><h2>Bad Words Filter</h2></div>
<div class="span-19 last i">If you have bad word filtering enabled, this is where you can add words to filter.<br/><a href="{$root}ajax/bot/badwords_default" target="badwords">View our default list.</a></div>
<script language="javascript">
{literal}
function UpdateBadWords() {
	new Ajax.Updater('badwords_dropdown',root+'ajax/bot/badwords/'+bot_id)
}

function AddBadWords(s) {
	new Ajax.Updater('badwords_dropdown',root+'ajax/bot/badwords/'+bot_id, {
		method: 'post',
		parameters: { badword: $('badwords_add').value }
	});
	$('badwords_add').value = '';
}

function RemoveBadWords() {
	e = $('badwords');
	s = ''
	for(var i=0; i<e.options.length; i++) {
		if(e.options[i].selected) {
			s += e.options[i].value+'|||||'
		}
	}
	new Ajax.Updater('badwords_dropdown',root+'ajax/bot/badwords/'+bot_id, {
		method: 'post',
		parameters: { remove_badword: s }
	});
}

UpdateBadWords();
{/literal}
</script>
<div class="span-19 last">
	<div class="span-3 b">Bad Words:</div>
	<div class="span-5" id="badwords_dropdown">&nbsp;</div>
	<div class="span-11 last b">
		Add Word:
		<input type="text" id="badwords_add" name="badwords_add" size="10" maxlength="50" />
		<input type="button" id="badwords_submit" name="badwords_submit" value="Add" onclick="AddBadWords(this.value); return false" />
	</div>
</div>
{/if}


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last"><h2>User Blacklist</h2></div>
<div class="span-19 last i">If you have problem users or spam-bots you'd like to block from posting, add them here.</div>
<script language="javascript">
{literal}
function UpdateBlacklist() {
	new Ajax.Updater('blacklist_dropdown',root+'ajax/bot/blacklist/'+bot_id)
}

function AddBlacklist(s) {
	new Ajax.Updater('blacklist_dropdown',root+'ajax/bot/blacklist/'+bot_id, {
		method: 'post',
		parameters: { blacklist: $('blacklist_add').value }
	});
	$('blacklist_add').value = '';
}

function RemoveBlacklist() {
	e = $('blacklist');
	s = ''
	for(var i=0; i<e.options.length; i++) {
		if(e.options[i].selected) {
			s += '|'+e.options[i].value+'|'
		}
	}
	new Ajax.Updater('blacklist_dropdown',root+'ajax/bot/blacklist/'+bot_id, {
		method: 'post',
		parameters: { remove_blacklist: s }
	});
}

UpdateBlacklist();
{/literal}
</script>
<div class="span-19 last">
	<div class="span-3 b">Blacklist Users:</div>
	<div class="span-5" id="blacklist_dropdown">&nbsp;</div>
	<div class="span-11 last b">
		Add User:
		<input type="text" id="blacklist_add" name="blacklist_add" size="10" maxlength="50" />
		<input type="button" id="blacklist_submit" name="blacklist_submit" value="Add" onclick="AddBlacklist(this.value); return false" />
	</div>
</div>