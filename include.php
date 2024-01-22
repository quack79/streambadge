<div class="twitch-main-wrapper">
	<?php echo '<a class="twitch-link" href="https://www.twitch.tv/' . $username . '" target="_top">' . "\n"; ?>
		<div class="twitch-main-wrapper-inner">
			<div class="twitch-twitch-logo-wrapper">
				<div class="twitch-icon-twitch"><img src="image/twitch.gif" width="45" height="45" /></div>
			</div>
			<div class="twitch-status-wrapper">
				<div class="twitch-status-wrapper-inner">
					<div class="twitch-status-live"> <!-- IF ONLINE -->
						<div class="twitch-live-marker"></div>
						<span>LIVE NOW!</span>
					</div>
					<div class="twitch-status-offline"> <!-- IF OFFLINE -->
						<span>CURRENTLY OFFLINE</span>
					</div>
				</div>
			</div>
		</div>
	</a>
</div>