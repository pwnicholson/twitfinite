<ul>
<li><a {if $url[0]=='home' && !$url[1]}class="current"{/if} href="{$root}home">Home</a></li>
<li><a {if $url[0]=='home' && $url[1]=='about'}class="current"{/if} href="{$root}home/about">About</a></li>
<li><a {if $url[0]=='home' && $url[1]=='directory'}class="current"{/if} href="{$root}home/directory">Bot Directory</a></li>
<li><a {if $url[0]=='home' && $url[1]=='userguide'}class="current"{/if} href="{$root}home/userguide">User Guide</a></li>
<li><a {if $url[0]=='home' && $url[1]=='adminguide'}class="current"{/if} href="{$root}home/adminguide">Admin Guide</a></li>
<li><a {if $url[0]=='home' && $url[1]=='signup'}class="current"{/if} href="{$root}home/signup">Sign Up</a></li>
<li><a {if $url[0]=='home' && $url[1]=='contact'}class="current"{/if} href="{$root}home/contact">Contact Us</a></li>
<li><a {if $url[0]=='home' && $url[1]=='login'}class="current"{/if} href="{$root}home/login">Log In</a></li>
</ul>