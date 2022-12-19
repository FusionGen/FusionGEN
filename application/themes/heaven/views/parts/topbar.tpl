<!-- TopBar.Start -->
<div class="navbar top-bar">
	<div class="container">
		<a class="navbar-brand" href="{$url}">{$serverName}</a>
		
		<div class="{if $isOnline}dropdown{/if} user ms-auto">
			{if !$isOnline}
				<a href="{$url}login" class="btn btn-outline-primary">Log In</a>
				<a href="{$url}register" class="btn btn-primary">Register</a>
			{else}
				<div class="user-points d-none d-lg-inline-block">
					<a href="{$url}donate" class="donation-points" role="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{lang('donation_points', 'ucp')}">
						<i class="fa-solid fa-coins"></i>
						{$CI->user->getDp()}
					</a>
					
					<a href="{$url}vote" class="vote-points" role="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{lang('voting_points', 'ucp')}">
						<i class="fa-solid fa-coins"></i>
						{$CI->user->getVp()}
					</a>
				</div>
				
				<a class="dropdown-toggle text-light text-upper" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
					<img class="rounded-circle me-3" src="{$CI->user->getAvatar()}" alt="Avatar">
					{$CI->user->getNickname()}
				</a>

				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
					<li><a class="dropdown-item" href="{$url}ucp"><i class="fas fa-user"></i>User Panel</a></li>
					{if $CI->user->isGm()}<li><a class="dropdown-item" href="{$url}mod"><i class="fas fa-key"></i>Mod Panel</a></li>{/if}
					{if $CI->user->isAdmin()}<li><a class="dropdown-item" href="{$url}admin"><i class="fas fa-cog"></i>Admin Panel</a></li>{/if}
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="{$url}logout"><i class="fas fa-right-from-bracket"></i>Logout</a></li>
				</ul>
			{/if}
		</div>
		
		<button class="navbar-toggler d-inline-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fas fa-bars"></i>
		</button>
		
	</div>
</div>
<!-- TopBar.End -->