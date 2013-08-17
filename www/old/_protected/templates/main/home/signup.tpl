{if !$msg}

<form method="post" action="{$root}home/signup">

<div class="span-19 last">
	<div class="span-19 last">
		<p>
			Like what you see?  Use the form below to request your Twitter bot be set up with the ReTweetBot.com service.  Please have your
			the Twitter account you would like to use for the bot already set up.
		</p>
	</div>

	<div class="span-19 last">
		{if $err.firstname}<div class="span-19 last err">{$err.firstname}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="firstname">First name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="firstname" name="firstname" size="16" value="{$_p.firstname}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.lastname}<div class="span-19 last err">{$err.lastname}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="lastname">Last name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="lastname" name="lastname" size="16" value="{$_p.lastname}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.email}<div class="span-19 last err">{$err.email}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="email">E-mail address:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="email" name="email" size="16" value="{$_p.email}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.twitter_bot}<div class="span-19 last err">{$err.twitter_bot}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="twitter_bot">Bot name:</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="twitter_bot" name="twitter_bot" size="16" value="{$_p.twitter_bot}" />
		</div>
	</div>
	
	<div class="span-19 last">
		{if $err.about_bot}<div class="span-19 last err">{$err.about_bot}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="about_bot">About your bot:</label>
		</div>
		<div class="span-16 last">
			<textarea id="about_bot" name="about_bot" rows=5 cols=40>{$_p.about_bot}</textarea>
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">
			<label class="form_label" for="how_did_you_hear">How did you learn about us?</label>
		</div>
		<div class="span-16 last">
			<input type="text" id="how_did_you_hear" name="how_did_you_hear" size="32" value="{$_p.how_did_you_hear}" />
		</div>
	</div>

	<div class="span-19 last">
		{if $err.captcha}<div class="span-19 last err">{$err.captcha}</div>{/if}
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			{$captcha}
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" id="submit" name="submit" value="Submit" />
		</div>
	</div>

</div>

</form>

{/if}