<!-- Header Section.Start -->
<header class="header" header>
	<div gradient gradient-1></div>
	<div gradient gradient-2></div>

	<div line line-l></div>
	<div line line-r></div>

	<div arrow></div>
	
	<!-- Navbar.Start -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<!-- Navbar.Start -->
				<nav class="navbar navbar-expand-xl">
					<h1 hidden>{$serverName}</h1>
	
					<!-- Brand.Start -->
					<a href="{$url}" class="navbar-brand">
						<img width="55" height="48" alt="logo" src="{$url}application/themes/default/assets/images/graphics/logo.png" />
						<span class="text-ellipsis">
							<b>{$serverName}</b>
						</span>
					</a>
					<!-- Brand.End -->
	
					<!-- Collapse.Start -->
					<div class="navbar-collapse collapse-primary collapse" collapse="navbar-primary">
						<ul class="navbar-nav mx-auto">
							{foreach from=$menu_top item=menu}
								{if $menu.dropdown_id != 0}{continue}{/if}
								{if $menu.lrd == "D"}
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											{$menu.name}
										</a>
										<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
											{foreach from=$menu_top item=d_menu}
												{if $d_menu.dropdown_id != $menu.id}{continue}{/if}
												<li><a class="dropdown-item" {$d_menu.link}>{$d_menu.name}</a></li>
											{/foreach}
										</ul>
									</li>
								{else}
									<li class="nav-item">
										<a class="nav-link {if $menu.active}nav-active{/if}" {$menu.link}>{$menu.name}</a>
									</li>
								{/if}
							{/foreach}
					</div>
	
					<div class="navbar-collapse collapse-secondary collapse">
						<ul class="navbar-nav ms-auto">
							<li class="nav-item"><a href="#" class="btn-blue -outline -noise text-ellipsis" title="Download launcher">Download launcher</a></li>
						</ul>
					</div>
					<!-- Collapse.End -->
	
					<!-- Toggler.Start -->
					<a href="javascript:void(0)" class="navbar-toggler" onclick="$('[collapse=navbar-primary]').stop(true, true).slideToggle('fast', function() { ($(this).is(':visible') ? $('.navbar-toggler').addClass('open') : $('.navbar-toggler').removeClass('open')) })"><span line line-t></span><span line line-m></span><span line line-b></span></a>
					<!-- Toggler.End -->
				</nav>
				<!-- Navbar.End -->
			</div>
		</div>
	</div>
	<!-- Navbar.End -->
</header>
<!-- Header Section.End -->