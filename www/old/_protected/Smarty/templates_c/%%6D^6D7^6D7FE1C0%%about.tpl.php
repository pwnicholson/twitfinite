<?php /* Smarty version 2.6.18, created on 2010-09-21 01:40:01
         compiled from main/home/about.tpl */ ?>
<div class="span-19 last">

<p>From the founder (<a href="http://twitter.com/pwnicholson">@pwnicholson</a>):</p>

<p>I hate hashtags.</p>

<p>Now, I know hashtags have a place. For very large groups (for instance, those tweeting about the presidential debates all over the
country), hashtags make sense. It allows people to search for a given tag and see what anyone has to say about a topic.</p>

<p>But there is a problem with hashtags.<br/>
For large, but closed (and relative to the larger Twitter community: small) groups, hashtags are a mess and create all sorts of issues.</p>

<p>EXAMPLE PROBLEM:<br/>
Today many geeks, including myself, are at BarCamp in Nashville. They are encouraging everyone to hashtag tweets with #bcn08. But the
problem is, I can garuntee you there are people who normally follow myself, Christy, Jackson, Kate, Alison, etc who aren't the least
bit interested in BarCamp. Well, tough for them because thanks to only using hashtags, we're going to flood their Twitter feeds with
what is essentially a private conversation for those participating in BarCamp.</p>

<p>There is a solution though!</p>

<p>Last year's BarCamp (back in 2007) featured a basic retweet service that searched tweets for a certain string ("BCN") and posted it to
one Twitter account (go search back to posts in 2007). This let everyone that wanted to "hear" people talking about BarCamp follow one
account and not miss out. That way they don't have to follow everyone at BarCamp and hear them talk about their kids later on. You just
hear what they have to say about BarCamp, but nothing else. Awesome.</p>

<p>That was only part of the solution though. There were still issues.</p>

<p>Problem was, it looked for a simple string in any Tweets. In this case it was "BCN". So if, for instance, my buddy Jackson, who i already
follow on Twitter, said something with "BCN" in it, i got it twice in my feed. Not to mention the same problem of cluttering feeds with
things people don't want still applied.</p>

<p>THE SOLUTION:<br/>
So, the solution seemed pretty simple: change the retweet engine from repeating based on a simple string, and rather look for people who
Tweet @replies to the group account, or better yet, send direct messages to the account.</p>

<p>This gives two levels of filtering:
<ul>
	<li>Those who want to have @reply filtering setup on their Twitter feeds (only show @replies to people I'm following).</li>
    <li>I can keep messages to the group account out of my main Twitter stream by sending it as a DM.</li>
</ul>

<p>So, I had the brilliant (very very simple) idea (of taking someone else's idea and changing it). But I couldn't code it. My coding-fu
has long ago left me and if i can't do it with HTML and basic Javascript, i'm at a loss. Enter
Garrett (aka <a href="http://twitter.com/phragmunkee">@PhragMunkee</a>). He's a geek in Chattanooga that helped me setup a ReTweet
engine for Predators fans.</p>

<p>So, we now have <a href="http://twitter.com/PredFans">@PredFans</a>. Anyone can post to it by starting a tweet with an @reply (which
would leave the post in their normal stream as well), or send a direct message which leaves it out of thier normal stream and says it
only to those that want to follow the topic.</p>

<p>This is what the resulting stream looks like:<br/>
<img class="screenshot" src="<?php echo $this->_tpl_vars['root']; ?>
images/predfanstwitter.jpg" />
Clean, simple, and it doesn't clutter up the individual feeds and streams of the users involved.<br/>
As you can see, the most important factor is that it allows for very quick, real-time conversations among twitter users in a far better
way than traditional hashtags.</p>

<p>It also gives admins more control. While we have <a href="http://twitter.com/PredFans">@PredFans</a> wide open, you can restrict those
that can post to the group to only users you choose to follow with the group account. Creating a closed-posting group that anyone can
follow and read.</p>

<p>And yes, Twitter quickly granted us white-list status so we can poll the API once per minute to check for new posts. We could go faster,
but we're running on a borrowed server for now :-)</p>

</div>