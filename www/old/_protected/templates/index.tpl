<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title>{$site_name} | {$title}</title>
<script type="text/javascript" src="{$root}_js/prototype.js"></script>
<script type="text/javascript" src="{$root}_js/functions.js"></script>
<link rel="icon" type="image/png" href="{$root}images/Parrot-small.png" />
<link href="{$root}_css/calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$root}_css/blueprint/screen.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="{$root}_css/blueprint/print.css" type="text/css" media="print" />
<!--[if IE]><link rel="stylesheet" href="_css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<link href="{$root}_css/stylesheet.css?t={$css_time}" rel="stylesheet" type="text/css" />
<link href="{$root}_css/navlist-vert.css" rel="stylesheet" type="text/css" />
<link href="{$root}_css/navlist-hor.css" rel="stylesheet" type="text/css" />

<script language="javascript">
var root = '{$root}';
</script>

<meta name="description" content="ReTweetBot: A better way to have a conversation!" />
</head>
<body{if $onload} onload="{$onload}"{/if}>

<div id="content">
	<a href="{$root}home"><div id="header"><span>A better way to have a conversation!</span></div></a>
	
	<div class="container">
		<div class="span-24 last">
			<div class="span-5">
				<div id="navcontainer">
				{if $user_id}
					{include file="main/retweet/nav.tpl"}
				{else}
					{include file="main/home/nav.tpl"}
				{/if}
				</div>
				
				<div style="margin-right: 25px; margin-left: 25px;">
					<script type="text/javascript"><!--
					google_ad_client = "pub-6686761318058414";
					/* 120x240, created 2/28/09 */
					google_ad_slot = "7053245261";
					google_ad_width = 120;
					google_ad_height = 240;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
	
			<div id="bd" class="span-19 last">
			{if $url[0]=='bot' && $url[1]!='add'}
			{include file='main/bot/menu.tpl}
			{/if}
			{if $include}
			{if $title_alt}
			<div class="title">{$title_alt}</div>
			{elseif $title}
			<div class="title">{$title}</div>
			{/if}
			
			{if $err && $url[1]!='login'}
			<p>
			{section name=a loop=$err}
				<div class="err">{$err[a]}</div>
			{/section}
			{/if}
			{if $msg}
			{section name=a loop=$msg}
				<div class="msg">{$msg[a]}</div>
			{/section}
			</p>
			{/if}
			<div class="container">
			{include file="$include.tpl"}
			</div>
			{/if}
			</div>
		
		</div>
	</div>
</div>

{include file="footer.tpl"}

{if !$dev}
<script type="text/javascript">
{literal}
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2876312-6");
pageTracker._trackPageview();
} catch(err) {}
{/literal}
</script>
{/if}

</body>
</html>
