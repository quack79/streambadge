<!doctype html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<?php 
	$filemtime = filemtime(dirname(__FILE__) . '/css/status.css');
	echo "<link rel='stylesheet' id='twitch-status' href='/streambadge/css/status.css?ver=$filemtime' type='text/css' media='all' /> \n";
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
                    jQuery('.sst-main-wrapper').addClass('sst-main-wrapper-active');
                    // do animation
                    jQuery('.sst-status-text-live').addClass('sst-current-status');
                    setTimeout(function() {
                        jQuery('.sst-status-text-live').addClass('sst-current-status-active');
                        jQuery('.sst-status-wrapper').addClass('sst-status-wrapper-active');
                    }, 25);  
});					
</script>
<?php 
			} else {
?>
<script>
jQuery(function() {
                    console.log('OFFLINE') // show if offline
                    jQuery('.sst-main-wrapper').addClass('sst-main-wrapper-active');
					// do animation
                    jQuery('.sst-status-text-offline').addClass('sst-current-status');
                    setTimeout(function() {
                        jQuery('.sst-status-text-offline').addClass('sst-current-status-active');
                        jQuery('.sst-status-wrapper').addClass('sst-status-wrapper-active');
                    }, 25);
});
</script>
<?php 
	}
	} else {
		echo "You need to specify a username!";	
	}
?>

<!-- BEGIN MAIN WRAPPER -->
<div class="sst-main-wrapper">
	<?php echo "<a class='sst-twitch' href='https://www.twitch.tv/$username' target='_top'> \n"; ?>
		<div class="sst-main-wrapper-inner">
			<!-- BEGIN TWITCH LOGO -->
			<div class="sst-twitch-logo-wrapper">
				<div class="sst-icon-twitch"><img src="/streambadge/image/twitch.svg" width="35" height="35" /></div>
			</div>
			<!-- END TWITCH LOGO -->
			<!-- BEGIN STATUS -->
			<div class="sst-status-wrapper">
				<div class="sst-status-wrapper-inner">
					<!-- BEGIN IF ONLINE -->
					<div class="sst-status-text-live">
						<div class="sst-live-marker"></div>
						<span>LIVE NOW!</span>
					</div>
					<!-- END IF ONLINE -->
					<!-- BEGIN IF OFFLINE -->
					<div class="sst-status-text-offline">
						<span>CURRENTLY OFFLINE</span>
					</div>
					<!-- END IF OFFLINE -->
				</div>
			</div>
			<!-- END STATUS -->
		</div>
	</a>
</div>
<!-- END MAIN WRAPPER -->
		
</body>
</html>		
