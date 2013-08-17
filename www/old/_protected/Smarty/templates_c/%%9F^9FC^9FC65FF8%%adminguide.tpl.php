<?php /* Smarty version 2.6.18, created on 2010-09-21 01:40:03
         compiled from main/home/adminguide.tpl */ ?>
<div class="span-19 last">
	<div class="span-19 last"><h2>Best Practices</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Follow Us!</div>
		<div class="span-15 last">
			Follow our own <a href="http://twitter.com/retweetbot" target="_blank">@ReTweetBot</a> Twitter account to be notified
			of any updates to the <a href="http://www.retweetbot.com">ReTweetBot.com</a> service!
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Avoiding Auto-DMs</div>
		<div class="span-15 last">
			One thing that may be annoying with your bot is retweeting unwanted direct messages from other Twitter bots
			you may have auto-followed.  Some Twitter accounts or bots will automatically send you a direct message to
			thank you for following them (or to SPAM you with an ad).  We have done some research for you to try to help
			avoid this annoyance.  This requires some user intervention and sharing of Twitter passwords with other sites,
			so we're going to leave this entirely up to the owner.
			
			<ul>
				<li>
					<span class="b"><a href="http://www.chrisbrogan.com/jesse-stay-kills-his-own-robots-humans-rejoice/" target="_blank">Jesse Stay Kills His Own Robots- Humans Rejoice</a></span> - 
					How to disable automatic direct messages from SocialToo.com bots.
				</li>
				<li>
					<span class="b"><a href="http://www.tweeterblog.com/twitter-tools/how-to-stop-those-freakin-auto-dms/" target="_blank">How to STOP Those Freakin Auto Dm's</a></span> -
					How to disable automatic direct messages from Tweetlater bots.
				</li>
			</ul>
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>ReTweet Settings</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Show Names</div>
		<div class="span-15 last">
			Toggles the display of Twitter usernames in a re-tweeted message.  For example, if @twitteruser sent
			a message to <a href="http://twitter.com/retweetbot">@retweetbot</a>, the username would be pre-pended to the message -- "twitteruser: This is a message".
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Username Format</div>
		<div class="span-15 last">
			If Show Names is enabled, this will allow you to change how the pre-pended usernames will look.  The username variable is
			%%username%%.  The default we have set is "%%username%%:".  That will make your bot's tweets look something like
			"username: Some text".  Another example would be "(@%%username%%)".  This will turn out like "(@username) Some text".
			Adding the @ in front of the username will allow it to be clickable in your bot's tweets.  Be warned, however, that you
			MUST have any character in front of the @, otherwise your bot will send an @reply to that user and your other users will
			not be able to see the tweet.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Retweet Direct Messages</div>
		<div class="span-15 last">
			This popular feature allows your bot's friends to send direct messages to the bot to be re-tweeted.  This offers
			the advantage of not filling up your friends' Twitter streams with @replies.  One caveat with this feature is
			that Twitter seems to put a lower priority on direct messaging, so when Twitter is under a heavy load, direct
			messages to your bot may be delayed.  This is a rare occurance and usually only happens during peak times such as
			the Super Bowl or Oscars or other large events of that scale.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Retweet Replies</div>
		<div class="span-15 last">
			This allows your friends and followers to send @replies directed to your bot to have them re-tweeted.  The only
			down-side to this is that your friends' Twitter streams will display their @replies.  However, during heavy Twitter
			loads, Twitter seems to place a higher priority on @replies and injects them straight into the Twitter stream.  If
			your users seem to be having problems with direct message delays, have them try @replies instead.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Retweet Restriction</div>
		<div class="span-15 last">
			If enabled, this will restrict the users who can retweet through your bot.  There are 3 different settings:
			<ul>
				<li>
					<span class="b">No restrictions</span> - Just as it sounds.  There are no restrictions and anyone can retweet
					through your bot.
				</li>
				<li>
					<span class="b">Admins Only</span> - Only users in the Admin Users list will be able to retweet through your bot.
				</li>
				<li>
					<span class="b">Admins and Inclusions</span> - If you want more than just the admin users to be able to retweet,
					you can use this setting.  This way you can keep special control like the Twitter Console features to yourself
					but still allow other users to retweet.
				</li>
			</ul>
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>Friends and Followers</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Auto-follow Followers</div>
		<div class="span-15 last">
			This setting will set up your bot to automagically befriend any new followers.  This feature runs every 15
			minutes, so it may not immediately start following new followers.  Give it a few more minutes and you should
			see your bot's friend count increase.  You may wish to enable this setting to allow your followers to be able
			to send you direct messages.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Friends' Follower Cap</div>
		<div class="span-15 last">
			If you have auto-following of followers enabled, this will let you set a cap on the number of friends that follower has.
			Many spam bots will target any bots they discover that will auto-follow.  In an effort to try to curb bringing these
			spam bots into your bot's network, you can set a cap.  These bots are typically following a very high number of people,
			so we think that is probably a good way to tell.  The default cap is set at 1,000.  This is owner-configurable, though.
			If you set the cap to 0 (zero), it will simply ignore any cap.
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>Filtering</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Bad Word Filtering</div>
		<div class="span-15 last">
			If enabled, you can filter bad or inappropriate words a few different ways.  There are 4 different settings:
			<ul>
				<li>
					<span class="b">No filter</span> - Don't do any filtering.  Re-tweet everything as-is.
				</li>
				<li>
					<span class="b">Censor word</span> - Replace all but the first and last letters of a word with asterisks (*).
				</li>
				<li>
					<span class="b">Block entire post</span> - Simply do not allow the entire post to be re-tweeted.
				</li>
				<li>
					<span class="b">Delete word</span> - Re-tweet everything but the offending words.  This may cause some
					tweets to read rather oddly, but it is an option!
				</li>
			</ul>
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Link Filtering</div>
		<div class="span-15 last">
			If enabled, you can filter links (http://...).  There are 3 different settings:
			<ul>
				<li>
					<span class="b">No filter</span> - Don't do any filtering.  Re-tweet everything as-is.
				</li>
				<li>
					<span class="b">Delete link</span> - Simply delete the link from the text and that's it.
				</li>
				<li>
					<span class="b">Block entire post</span> - Do not allow the post to be re-tweeted.
				</li>
			</ul>
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>Hash Tags</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Auto-append Hash Tags</div>
		<div class="span-15 last">
			Enable this setting if you would like for your bot to automagically append hash tags to tweets.  The bot is smart
			enough to detect hash tags already included in the tweet and will not post the same hash tag twice.  It will also
			only append the number of hash tags that it can safely fit at the end of the message while still keeping the entire
			tweet under the default 140 characters.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Hash Tags</div>
		<div class="span-15 last">
			If you have enabled the auto-appending of hash tags, this is where you set the hash tags to be appended.  Add as many
			as you would like separated by spaces.  It prioritizes them from first to last.  See the note above about only appending
			as many hash tags as it can fit.
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>Bot Statistics</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Updates</div>
		<div class="span-15 last">
			This is the number of status updates that the ReTweetBot has posted to Twitter.  This number may not reflect what
			is shown by Twitter.  The cases for this are if you made updates with your bot before setting it up with ReTweetBot
			or you may have deleted updates from Twitter and not through ReTweetBot.  In the future, this statistic will reflect
			what you see in Twitter.
		</div>
	</div>

	<div class="span-19 last def">
		<div class="span-4 b">Tweeters</div>
		<div class="span-15 last">
			This is the number of users who have actually tweeted through your bot.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Friends</div>
		<div class="span-15 last">
			This is the number of Twitter users that your bot follows.  This number is updated from Twitter once per hour.
		</div>
	</div>
		
	<div class="span-19 last def">
		<div class="span-4 b">Followers</div>
		<div class="span-15 last">
			This is the number of Twitter users that follows your bot.  This number is updated from Twitter once per hour.
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>


<div class="span-19 last">
	<div class="span-19 last"><h2>User Lists</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Admin Users</div>
		<div class="span-15 last">
			Admin users are for the bot owner and any other users that the bot owner trusts to use special features.  Such
			features include the Twitter Console described below.  To add users, enter the usernames as they appear in Twitter
			and click the Add button.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Include Users</div>
		<div class="span-15 last">
			These are users that are allowed to retweet through the bot but do not have access to the special admin features.
			This list will only appear if you have set the Retweet Restrictions to "Admins and inclusions".  To add users, enter
			the usernames as they appear in Twitter and click the Add button.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Blacklisting</div>
		<div class="span-15 last">
			Have a user or SPAM bot that keeps posting or following your bot that you don't want?  Just visit the User Lists section
			to add that account to your blacklist.  That will prevent any further posting and your bot will no longer auto-follow that
			user should you choose to block the offending account.
		</div>
	</div>
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>

<div class="span-19 last">
	<div class="span-19 last"><h2>Twitter Console</h2></div>
	
	<div class="span-19 last def">
		<div class="span-4 b">What is it?</div>
		<div class="span-15 last">
			Our "Twitter Console" is the ability to remotely control your bot from another Twitter account.  We liken it
			to a command-line interface like you saw in the old DOS days (or in the current Linux days if you're that kind
			of geek).  You start the command with a set of letters followed by a pipe "|" and other parameters.  Commands
			and examples are below.  These commands can be issued via direct message or @reply.  We would recommend using
			direct messages for a majority of these commands so that nobody can see what you're about to make your bot do.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Admin Users</div>
		<div class="span-15 last">
			This is where you define what Twitter users are allowed to use your bot's Twitter console.  You can add or remove
			as many accounts as you would like whenever you would like.  A check is performed to make sure the Twitter user
			sending the command to your bot is an authorized admin.  If so, your bot will perform the command.  Otherwise, it
			will just toss the command out and never act upon it or re-tweet it.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Enable Confirmation DMs</div>
		<div class="span-15 last">
			Enabling this setting (it's enabled by default) will have the bot automatically send you confirmation direct messages
			whenever it processes a console command that you or an admin issued.  It will only send the message to the admin that
			issued the command.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Help (help)</div>
		<div class="span-15 last">
			Are you having problems remembering all of our Twitter console commands?  Just send "help|" to your bot using @reply or
			direct message and it will send you a list of available commands back via direct message.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Update Status (u)</div>
		<div class="span-15 last">
			This is the most basic of basic Twitter console commands.  It simply allows you to update your bot's Twitter status
			without pre-pending your Twitter username to the front of it.  To use, simply start a direct message or @reply to your
			bot with "u|" followed by your message.  So if you sent "u|this is some text" to your bot, it would simply say "this
			is some text" without any usernames or anything in front of the text.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Block User (block)</div>
		<div class="span-15 last">
			This is the console implementation of the blacklist feature.  To use, send a direct message or @reply to your bot in
			the format of "block|username" where "username" is the user you wish to block.  This will prevent that user from ever
			re-tweeting through your bot and will also un-follow them.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Direct Message to Admins (dma)</div>
		<div class="span-15 last">
			This handy little command allows you to send a direct message to all of the group admins that you have set up.  It can,
			in essence, allow you and your admins to carry on a private conversation amongst yourselves to discuss your bot.  To use
			this command simply send "dma|This is your text" to your bot using @reply or direct message.  It will then broadcast "This
			is your text" to all of the admins you have set up for your bot.  The admin who sends out the direct message broadcast
			will not receive a copy of the message.  So, if there is only one admin for your bot, you can't carry on a conversation
			with yourself!
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Set Hash Tags (hash)</div>
		<div class="span-15 last">
			This command will update the hash tags that are automatically appended to your bot's tweets.  This will not enable
			the auto-appending of hash tags if it is disabled.  To use the command, send "hash|#hashtag1 #hashtag2" to your bot
			via @reply or direct message.  Make sure that the hash tags are separated with spaces.  See Hash Tags section above
			for more information.
		</div>
	</div>

	<div class="span-19 last def">
		<div class="span-4 b">Delete Posts from User (del)</div>
		<div class="span-15 last">
			This command will delete the last X posts by a given user.  This is especially handy in case of spammers or automated
			direct messages getting retweeted by your bot.  To use the command, send "del|username X" to your bot via @reply or
			direct message.  Replace "username" with the screen name of the Twitter user, and replace X with the number of posts
			you would like to have deleted.  If you do not pass a number, only the last post will be deleted.  You may also pass "all" instead
			of a number and it will delete all posts by that screen name.
		</div>
	</div>
	
	<div class="span-19 last def">
		<div class="span-4 b">Delete Posts and Block User (nuke)</div>
		<div class="span-15 last">
			This command is simply an alias of the "block|username" and "del|username all" commands.  The "kill|username" command
			is an alias to this command as well.
		</div>
	</div>
		
</div>


<div class="span-19 last"><br/></div>
<div class="span-19 last"><br/></div>