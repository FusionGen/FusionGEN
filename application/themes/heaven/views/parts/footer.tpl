{* Initializing menus to bake them later *}
{$menus = ['left' => null, 'right' => null]}

{foreach from=$menu_bottom item=menu}
	{if $menu.lrd === 'L'}
		{capture assign=html}
			<li><a {if $menu.active}class="active"{/if} {$menu.link}>{$menu.name}</a></li>
		{/capture}
		{$menus.left = $menus.left|cat:$html}
	{elseif $menu.lrd === 'R'}
		{capture assign=html}
			<li><a {if $menu.active}class="active"{/if} {$menu.link}>{$menu.name}</a></li>
		{/capture}
		{$menus.right = $menus.right|cat:$html}
	{/if}
{/foreach}

<!-- Footer.Start -->
<footer class="footer" footer>
	<div class="container">
		<div class="row g-5 align-items-center">
			<div class="col-lg-12 col-xl-6">
				<div class="footer-copyright">
					<span>About us</span>
					{$about_us}
				</div>
			</div>

			<div class="col-lg-12 col-xl-4">
				<nav class="footer-navbar">
					<ul class="navbar-nav">
						{$menus.left}
					</ul>
					
					<ul class="navbar-nav">
						{$menus.right}
					</ul>

					<ul class="navbar-nav">
						{if $social['facebook']['enabled']}
						<li>
							<a target="_blank" href="{$social['facebook']['link']}">
								<span class="item-icon"><i class="fa-brands fa-facebook-f" style="width:16px;"></i></span>
								<span class="item-icon-text">@facebook</span>
							</a>
						</li>
						{/if}
						
						{if $social['twitter']['enabled']}
						<li>
							<a target="_blank" href="{$social['twitter']['link']}">
								<span class="item-icon"><i class="fa-brands fa-twitter" style="width:16px;"></i></span>
								<span class="item-icon-text">@twitter</span>
							</a>
						</li>
						{/if}
						
						{if $social['discord']['enabled']}
						<li>
							<a target="_blank" href="{$social['discord']['link']}">
								<span class="item-icon"><i class="fa-brands fa-discord" style="width:16px;"></i></span>
								<span class="item-icon-text">@discord</span>
							</a>
						</li>
						{/if}
						
						{if $social['teamspeak']['enabled']}
						<li>
							<a target="_blank" href="{$social['teamspeak']['link']}">
								<span class="item-icon"><i class="fa-brands fa-teamspeak" style="width:16px;"></i></span>
								<span class="item-icon-text">@teamspeak</span>
							</a>
						</li>
						{/if}
						
						{if $social['instagram']['enabled']}
						<li>
							<a target="_blank" href="{$social['instagram']['link']}">
								<span class="item-icon"><i class="fa-brands fa-instagram" style="width:16px;"></i></span>
								<span class="item-icon-text">@instagram</span>
							</a>
						</li>
						{/if}
						
						{if $social['youtube']['enabled']}
						<li>
							<a target="_blank" href="{$social['youtube']['link']}">
								<span class="item-icon"><i class="fa-brands fa-youtube" style="width:16px;"></i></span>
								<span class="item-icon-text">@youtube</span>
							</a>
						</li>
						{/if}
					</ul>
				</nav>
			</div>

			<div class="col-lg-12 col-xl-2">
				<!-- Brand.Start -->
				<a href="#" class="footer-brand">
					<img width="55" height="48" alt="logo" src="{$url}application/themes/default/assets/images/graphics/logo.png" />
					<span class="text-ellipsis">
						<b>{$serverName}</b>
					</span>
				</a>
				<!-- Brand.End -->
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container text-center pt-5">
			Copyright &copy; 
			
				{if $footer['since'] == date('Y')}
					{$footer['since']}
				{else}
					{$footer['since']} - {date('Y')}
				{/if}
				
			by <a href="#">FusionGen</a> All Rights Reserved
		</div>
	</div>
</footer>
<!-- Footer.End -->