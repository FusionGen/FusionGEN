<!-- TopBar.Start -->
<div class="section section-topbar" topbar>
	<div class="container-fluid">
		<div class="row align-items-center">			
			<div class="col-sm-12 col-md-5" social-media>
				<!-- Social media.Start -->
				<div class="social-media">
					<a href="{$social_media['facebook']}" target="_blank" class="social-btn btn-facebook"></a>
					<a href="{$social_media['twitter']}" target="_blank" class="social-btn btn-twitter"></a>
					<a href="{$social_media['youtube']}" target="_blank" class="social-btn btn-youtube"></a>
					<a href="{$social_media['discord']}" target="_blank" class="social-btn btn-discord"></a>
				</div>
				<!-- Social media.End -->
			</div>
	
			{if !$isOnline}
			<div class="col-sm-12 col-md-7" membership-bar="">
				<!-- Membership bar.Start -->
				<div class="membership-bar not-logged-in d-inline-flex flex-row align-items-center">
					<a href="{$url}login" class="nice_button btn-neon" title="Login">Login</a>
					<span sep=""></span><a href="{$url}register" class="nice_button btn-sky" title="Register">Register</a>
				</div>
				<!-- Membership bar.End -->
			</div>
			{else}
				<div class="col-sm-12 col-md-7" membership-bar>
				<!-- Membership bar.Start -->
				<div class="membership-bar logged-in d-inline-flex flex-row align-items-center">
				<div class="membership-bar-profile">
					<a href="{$url}ucp/avatar" class="profile-avatar" title="{$CI->user->getNickname()}'s Avatar" style="background-image:url('{$CI->user->getAvatar()}')" data-hasevent="1"></a>
				</div>
				<div class="membership-bar-info">
					<div class="info-welcome">Welcome <span>{$CI->user->getNickname()}</span>!</div>
					<div class="info-coins"><span><i text-gold="">{$CI->user->getDp()}</i> {lang('donation_points', 'main')}</span> &amp; <span><i text-silver="">{$CI->user->getVp()}</i> {lang('voting_points', 'main')}</span></div>
				</div>
				<div class="membership-bar-nav">
					<div class="dropdown" data-dropdown-initialized="true">
						<a href="#" id="membership-bar-dropdown" class="membership-bar-dropdown" data-bs-toggle="dropdown"></a>
						<ul class="dropdown-menu" aria-labelledby="membership-bar-dropdown">
							<li>
								<a href="{$url}ucp" class="dropdown-item" title="Account" data-hasevent="1">Account</a>
							</li>
							<li>
								<a href="{$url}vote" class="dropdown-item" title="Vote" data-hasevent="1">Vote</a>
							</li>
							<li>
								<a href="{$url}donate" class="dropdown-item" title="Donate" data-hasevent="1">Donate</a>
							</li>
							<li>
								<a href="{$url}store" class="dropdown-item" title="Store" data-hasevent="1">Store</a>
							</li>
							<li>
								<a href="{$url}logout" class="dropdown-item" title="Logout" data-hasevent="1">Logout</a>
							</li>
						</ul>
					</div>
					<nav class="navbar">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a href="{$url}ucp" class="nav-link" title="Account" data-hasevent="1">Account</a>
							</li>
							<li class="nav-item">
								<a href="{$url}vote" class="nav-link nav-animation" title="Vote" data-hasevent="1">Vote</a>
							</li>
							<li class="nav-item">
								<a href="{$url}donate" class="nav-link" title="Donate" data-hasevent="1">Donate</a></li>
							<li class="nav-item">
								<a href="{$url}store" class="nav-link" title="Store" data-hasevent="1">Store</a></li>
							<li class="nav-item">
								<a href="{$url}logout" class="nav-link" title="Logout" data-hasevent="1">Logout</a>
							</li>
						</ul>
					</nav>
				</div>
				</div><!-- Membership bar.End -->
				</div>
			{/if}
		</div>
	</div>
</div>
<!-- TopBar.End -->