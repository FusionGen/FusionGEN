{$head}
	<body>
		{$modals}
		<div id="top">
        	
		</div>
		<div id="wrapper">
			<div id="header" {$header_url}></div>
			<div id="menu">
				<ul>
					{foreach from=$menu_top item=menu_1}
						<li><a {$menu_1.link}>{$menu_1.name}</a></li>
					{/foreach}
				</ul>
			</div>
			
			<!-- body start -->
			<div id="body">
            	<div id="space"></div>
                
				<div id="left">
					<div class="left_box">
						<div class="left_box_top">Site menu</div>
						<ul>
                        	{foreach from=$menu_side item=menu_2}
								<li><a {$menu_2.link}>{$menu_2.name}</a></li>
							{/foreach}
                        </ul>
					</div>
                    
                    {foreach from=$sideboxes item=sidebox}
                    <div class="left_box">
						<div class="left_box_top">{$sidebox.name}</div>
						<div style="padding:5px;">
								{$sidebox.data}
							</div>
					</div>
					{/foreach}
				</div>
				
				<div id="right">
					<div class="right_box" id="slider_box" {if !$show_slider}style="display:none;"{/if}>
						<div id="slider">
							{foreach from=$slider item=image}
								<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
							{/foreach}
						</div>
					</div>
					{$page}
				</div>
                
                <div class="clear"></div>
			</div>
			<!-- body end -->
			
			<div id="footer">
                &copy; Copyright {date("Y")} {$serverName}

				<div id="cms">
                	<a href="http://www.fusion-hub.com" target="_blank"></a>
                </div>
            </div>
		</div>
	</body>
</html>