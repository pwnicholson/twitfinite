<table class="calendar_container">
	<tr>
		<td class="calendar_nav">&lt;&lt;</td>
		<td class="calendar_month" colspan="5">{$month_year}</td>
		<td class="calendar_nav">&gt;&gt;</td>
	</tr>
	<tr class="calendar_week">
		<td class="calendar_dow">Su</td>
		<td class="calendar_dow">Mo</td>
		<td class="calendar_dow">Tu</td>
		<td class="calendar_dow">We</td>
		<td class="calendar_dow">Th</td>
		<td class="calendar_dow">Fr</td>
		<td class="calendar_dow">Sa</td>
	</tr>
	{counter start=-1 assign=wd}
	<tr class="calendar_week">
	{section name=a loop=$days}
	{counter assign=wd}
	{if $wd==7}
	</tr>
	{counter start=0 assign=wd}
	<tr class="calendar_week">
	{/if}
	<td class="calendar_day">{$days[a]}</td>
	{/section}
	</tr>
</table>