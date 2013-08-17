<div class="span-19 last">

	<form method="post">

	<div class="span-19 last">
		<div class="span-4">
			<label for="to">To:</label>
		</div>
		<div class="span-15 last">
			<select name="to" id="to">
				<option value="admin" {if $_p.to=='admin'}selected{/if}>Admins (For testing)</option>
				<option value="subscribers" {if $_p.to=='subscribers'}selected{/if}>Subscribers</option>
				<option value="all" {if $_p.to=='all'}selected{/if}>Everyone (Not recommended)</option>
			</select>
		</div>
	</div>

	<div class="span-19 last">
		{if $err.from_name}<div class="span-4">&nbsp;</div><div class="span-15 last err">{$err.from_name}</div>{/if}
		<div class="span-4">
			<label for="from_name">From Name:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="from_name" id="from_name" size="30" maxlength="50" value="{if $_p.from_name}{$_p.from_name}{else}@ReTweetBot{/if}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.from_address}<div class="span-4">&nbsp;</div><div class="span-15 last err">{$err.from_address}</div>{/if}
		<div class="span-4">
			<label for="from_address">From Address:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="from_address" id="from_address" size="30" maxlength="50" value="{if $_p.from_address}{$_p.from_address}{else}info@retweetbot.com{/if}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.subject}<div class="span-4">&nbsp;</div><div class="span-15 last err">{$err.subject}</div>{/if}
		<div class="span-4">
			<label for="subject">Subject:</label>
		</div>
		<div class="span-15 last">
			<input type="text" name="subject" id="subject" size="30" maxlength="200" value="{$_p.subject}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.message}<div class="span-4">&nbsp;</div><div class="span-15 last err">{$err.message}</div>{/if}
		<div class="span-4">
			<label for="message">Message:</label>
		</div>
		<div class="span-15 last">
			<textarea name="message" id="message">{$_p.message}</textarea>
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-4">&nbsp;</div>
		<div class="span-15 last">
			<input type="submit" name="submit" id="submit" value="Send E-mail" />
		</div>
	</div>
	
	</form>
	
</div>