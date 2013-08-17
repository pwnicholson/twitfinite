{if !$msg}

<form method="post" action="{$root}home/contact">

<div class="span-19 last">

	<div class="span-19 last">
		<p>Use the form below to send us a message.</p>
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
		{if $err.message}<div class="span-19 last err">{$err.message}</div>{/if}
		<div class="span-3">
			<label class="form_label" for="about_bot">Your message:</label>
		</div>
		<div class="span-16 last">
			<textarea id="message" name="message" rows=5 cols=40>{$_p.message}</textarea>
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
