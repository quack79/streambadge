<!-- BEGIN MAIN WRAPPER -->
<div class="twitch-main-wrapper">
	<?php echo '<a class="twitch-link" href="https://www.twitch.tv/' . $username . '" target="_top">' . "\n"; ?>
		<div class="twitch-main-wrapper-inner">
			<!-- BEGIN TWITCH LOGO -->
			<div class="twitch-twitch-logo-wrapper">
				<div class="twitch-icon-twitch"><img src="/streambadge/image/twitch.gif" width="45" height="45" /></div>
			</div>
			<!-- END TWITCH LOGO -->
			<!-- BEGIN STATUS -->
			<div class="twitch-status-wrapper">
				<div class="twitch-status-wrapper-inner">
					<!-- BEGIN IF ONLINE -->
					<div class="twitch-status-live">
						<div class="twitch-live-marker"></div>
						<span>LIVE NOW!</span>
					</div>
					<!-- END IF ONLINE -->
					<!-- BEGIN IF OFFLINE -->
					<div class="twitch-status-offline">
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