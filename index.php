<!doctype html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<?php 
$filemtime = filemtime(dirname(__FILE__) . '/css/status.css');
echo '<link rel="stylesheet" href="/streambadge/css/status.css?ver=$filemtime" type="text/css" media="all" />' . "\n";
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+Mono">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body> 
<?php 
require_once('twitchWrapper.php');
use TwitchApiClass\twitchWrapper;

if (!empty($_GET) && (!empty($_GET['user']))) {
  $call = new twitchWrapper();
  $username = htmlentities($_GET['user']);
  $call->getUserStream($username);
  if ($call->userIsLive()) {
?>
<script>
jQuery(function() {
  console.log('LIVE') // show if online
  jQuery('.twitch-main-wrapper').addClass('twitch-main-wrapper-active');
  jQuery('.twitch-status-live').addClass('twitch-current-status');
  setTimeout(function() {
    jQuery('.twitch-status-live').addClass('twitch-current-status-active');
    jQuery('.twitch-status-wrapper').addClass('twitch-status-wrapper-active');
  }, 25);  
});					
</script>
<?php 
  include 'include.php';
  } else {
?>
<script>
jQuery(function() {
  console.log('OFFLINE') // show if offline
  jQuery('.twitch-main-wrapper').addClass('twitch-main-wrapper-active');
  jQuery('.twitch-status-offline').addClass('twitch-current-status');
  setTimeout(function() {
    jQuery('.twitch-status-offline').addClass('twitch-current-status-active');
    jQuery('.twitch-status-wrapper').addClass('twitch-status-wrapper-active');
  }, 25);
});
</script>
<?php 
  include 'include.php';
  }
} else {
  echo "You need to specify a username!";	
}
?>
</body>
</html>
