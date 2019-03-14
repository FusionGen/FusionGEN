{$head}

	<body>
		<div id="container">
			{$modals}
			
			<header>
				<h1><a class="logo-head" href="{$url}" title="welcome to {$serverName}"><img class="logo" src="{$CI->template->image_path}logo.png" width="212" height="262" alt="{$serverName}" title="{$serverName}" /></a></h1>
				
				<div id="top-menu" class="menu">
					<ul>
						{foreach from=$menu_top item=menu_1}
							<li><a {$menu_1.link}>{$menu_1.name}</a></li>
						{/foreach}
					</ul>
				</div>
			</header>
			
			<div class="search_bar">
				
			</div>
			
			
			
			<div id="main">
				<div class="middle_background"></div>
				
				<aside id="right">
					<div id="wlc_msg" class="welcome_to closeable closed" style="display:none">
						<a href="javascript:void(0)" class="close-btn"></a>
						<div class="body">
						<span>Welcome to {$serverName}</span>
							<p>
						<div class="description">World of Warcraft Burning Crusade Private Server
								</br>With a Blizzlike playstyle consisting of 5x faster than the original speed.
									</br>Experience a true Burning Crusade feeling today!
									</br></br><a href="https://www.yourdomain.com/register">Register Here</a></div>
									<b><br/>
								{if $isOnline}
							<p>
								{else}
							{/if}
							</p>
						</div>
					</div>
					
					{$page}
				</aside>
				
				<aside id="left">		
					<section class="box">
						<h3 class="head">Main menu</h3>
						<ul id="left-menu">
							{foreach from=$menu_side item=menu_2}
								<li>
									<a {$menu_2.link}>{$menu_2.name}</a>
									<p><a {$menu_2.link}>{$menu_2.name}</a></p>
								</li>
							{/foreach}
						</ul>
					</section>
					
					{foreach from=$sideboxes item=sidebox}
						<section class="sidebox box">
							{if !empty($sidebox.name)}
								<h4 class="head">{$sidebox.name}</h4>
							{/if}
							<div class="body">
								{$sidebox.data}
							</div>
						</section>
					{/foreach}
				</aside>
				
				<div class="clear"></div>
			</div>
		</div>
		
		<footer>
			<div class="footer">
				<center><a href="{$url}page/tos"> Terms of Service </a> - <a href="{$url}contact-us"> Contact Us</a>
				</br>Copyright © {$serverName}™ 2019. All Rights Reserved.
				</br>Initial Code by E.Darksider - Reworked and Designed by OMGhixD
				</br></br> Powered by <a href="https://gitlab.com/omghixd/fusiongen">FusionGEN</center>
				<span></span>
			</div>
		</footer>
		        <script type="text/javascript" id="cookieinfo"
	                src="//cookieinfoscript.com/js/cookieinfo.min.js"
	                data-bg="#1e1e1e"
	                data-fg="#3d3d3d"
	                data-link="#dc8044"
	                data-cookie="CookieInfoScript"
	                data-text-align="left"
                    data-close-text="Got it!">
                </script>
	</body>
</html>