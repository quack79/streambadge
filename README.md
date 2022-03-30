As this code uses the Twitch API, you need to register your application on the [Twitch developer site](https://dev.twitch.tv/console/apps/create). When creating the app, you will need to enter a redirect URI, basdic 

Once you create a developer application, you are assigned a client ID, and you will need to create a client Secret as well.

You will need to edit the twitchWrapper.php file and update the following lines:

>    private const CLIENT_ID = 'REDACTED'; 
>    private const CLIENT_SECRET = 'REDACTED';

Replaced REDACTED with your new ID and Secret.

Upload the files to your server and place this code in your HTML:

> <iframe src="/streambadge/?user=TWITCHUSERNAME" name="twitch-status" scrolling="no" height="50px" width="220px" style="border: none;"></iframe>

Replace TWITCHUSERNAME with the channel name you require.

twitchWrapper.php is a modified version of corbpie's https://github.com/cp6/Twitch-API-class I simply removed all functions unnecessary for these needs.
