{$head}
	<body>
		{$modals}
		<section id="wrapper">
			<header {$header_url}></header>
			<div id="top"></div>
			
			<nav>
				<ul>
					{foreach from=$menu_top item=menu_1}
						<li><a {$menu_1.link}>{$menu_1.name}</a></li>
					{/foreach}
				</ul>
			</nav>
			
			<!-- body start -->
			<section id="body">
            	<div id="space"></div>
				<aside>
					<section class="side_box">
						<div class="side_box_top">Navigation</b></div>
						<ul>
							{foreach from=$menu_side item=menu_2}
								<li><a {$menu_2.link}>{$menu_2.name}</a></li>
							{/foreach}
                        </ul>
					</section>
					
					{foreach from=$sideboxes item=sidebox}
						<section class="side_box">
							<div class="side_box_top">{$sidebox.name}</div>
							<div style="padding:5px;">
								{$sidebox.data}
							</div>
						</section>
					{/foreach}
                    
				</aside>
				
				<section id="main">
					<div id="slider_wrapper" {if !$show_slider}style="display:none;"{/if}>
						<div id="slider">
							{foreach from=$slider item=image}
								<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
							{/foreach}
						</div>
					</div>

					{$page}
				</section>
                
                <div class="clear"></div>
			</section>
			<!-- body end -->
			
			<footer>
				&copy; Copyright {date("Y")} {$serverName}

				<div id="cms">
                	<a href="http://www.fusion-hub.com" target="_blank"></a>
                </div>
            </footer>
		</section>
	</body>
</html>
