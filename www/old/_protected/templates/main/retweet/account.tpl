<form method="post" action="{$root}retweet/account{if $admin==1 && $url[2]}/{$url[2]}{/if}">

<div class="span-19 last">
	{if $msg.account}<div class="span-19 last msg">{$msg.account}</div>{/if}

	<div class="span-19 last">
		{if $err.username}<div class="span-19 last err">{$err.username}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="username">User name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="username" name="username" size="16" value="{$user.username}" disabled="true" />
		</div>
	</div>

	<div class="span-19 last">
		{if $err.firstname}<div class="span-19 last err">{$err.firstname}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="firstname">First name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="firstname" name="firstname" size="16" value="{$user.firstname}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.lastname}<div class="span-19 last err">{$err.lastname}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="lastname">Last name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="lastname" name="lastname" size="16" value="{$user.lastname}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.email}<div class="span-19 last err">{$err.email}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="email">E-mail Address:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="email" name="email" size="16" value="{$user.email}" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="admin">Get E-mail Updates:</label>
		</div>
		<div class="span-16 last">
			<input type="checkbox" id="newsletter" name="newsletter" value="Y" {if $user.newsletter==1}checked="true"{/if}/>
		</div>
	</div>
	
	{if $admin==1}
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="admin">Admin:</label>
		</div>
		<div class="span-16 last">
			<input type="checkbox" id="admin" name="admin" value="Y" {if $user.admin==1}checked="true"{/if}/>
		</div>
	</div>
	{/if}
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit1" name="submit" value="Submit" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-19 last b">
			<br/>
			Reset Password
		</div>
		{if $err.password}<div class="span-19 last err">{$err.password}</div>{/if}
		{if $msg.password}<div class="span-19 last msg">{$msg.password}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="password1">New Password:</label>
		</div>
		<div class="span-16 last">
			<input type="password" id="password1" name="password1" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="password2">Confirm:</label>
		</div>
		<div class="span-16 last">
			<input type="password" id="password2" name="password2" size="16" />
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit2" name="submit" value="Submit" />
		</div>
	</div>
	
</div>

</form>