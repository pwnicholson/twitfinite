<ul>
<li><a {if ($url[0]=='retweet' && !$url[1]) || $url[0]=='bot'}class="current"{/if} href="{$root}retweet">My Bots</a></li>
<li><a {if $url[0]=='retweet' && $url[1]=='account'}class="current"{/if} href="{$root}retweet/account">My Account</a></li>
<li><a {if $url[0]=='home' && $url[1]=='directory'}class="current"{/if} href="{$root}home/directory">Bot Directory</a></li>
<li><a {if $url[0]=='home' && $url[1]=='userguide'}class="current"{/if} href="{$root}home/userguide">User Guide</a></li>
<li><a {if $url[0]=='home' && $url[1]=='adminguide'}class="current"{/if} href="{$root}home/adminguide">Admin Guide</a></li>
<li><a {if $url[0]=='home' && $url[1]=='contact'}class="current"{/if} href="{$root}home/contact">Contact Us</a></li>
{if $admin==1}
<li><a {if $url[0]=='admin'}class="current"{/if} href="{$root}admin">Admin</a></li>
{/if}
<li><a {if $url[0]=='retweet' && $url[1]=='logout'}class="current"{/if} href="{$root}logout">Log Out</a></li>
</ul>