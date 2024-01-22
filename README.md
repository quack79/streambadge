As this code uses the Twitch API, you need to register your application on the [Twitch Developers](https://dev.twitch.tv/console/apps/create) site.
When creating the app, you will need to enter an OAuth redirect URL - use the URL where the script will be located.

Choose "Website Integration" as the category and "Confidential" as Client Type

Once you create a developer application, you are assigned a client ID, and you will need to create a client Secret.

You will need to edit the twitchWrapper.php file and update the following lines:

>    private const CLIENT_ID = 'CHANGEME';
>    private const CLIENT_SECRET = 'CHANGEME';
Replace CHANGEME with your new ID and Secret.

Check the location where the token will be saved on your server. It must NOT be publically accessible.

Upload the files to your server and place this code in your HTML:

> <iframe src="/streambadge/?user=TWITCHUSERNAME" name="twitch-status" scrolling="no" height="50px" width="220px" style="border: none;"></iframe>

Replace TWITCHUSERNAME with the channel name you require.

"twitchWrapper.php" is a modified version of corbpie's [Twitch-API-Class](https://github.com/cp6/Twitch-API-class),  I have simply removed all unnecessary functions.