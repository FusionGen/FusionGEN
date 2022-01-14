{$head}

	<body>

		<!-- The website -->
		<div id="wrapper">

					<!-- Navigation menu -->
			<nav>
				<ul>
					
						{foreach from=$menu_top item=menu_1}
							<li><a {$menu_1.link}>{$menu_1.name}</a></li>
						{/foreach}
					
				</ul>

			<!-- Header -->
			<header>
				<!-- (Optional) Text based header -->
				<div class="headline">{$serverName}</div>
			</header>

					<article id="slider_wrapper" {if !$show_slider}style="display:none;"{/if}>
						<div id="slider">
							{foreach from=$slider item=image}
								<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
							{/foreach}
						</div>
					</article>

				<!-- Clear the float to make it expand the box -->
				<div class="clear"></div>
			</nav>

			<!-- Main website area -->
		<div class="main">
			<section id="main">

				<!-- Right side (sideboxes)-->
				<aside id="right">

					<!-- Side menu -->
					<article>
						<div class="headline">Menu</div>
						
						<div class="content" id="menu">
							<ul>
								{foreach from=$menu_side item=menu_2}
									<li><a {$menu_2.link}>{$menu_2.name}</a></li>
								{/foreach}
							</ul>
						</div>
					</article>

					<!-- Sidebox -->
					{foreach from=$sideboxes item=sidebox}
						<article>
							<div class="headline">{$sidebox.name}</div>
							<div class="content">
								{$sidebox.data}
							</div>
						</article>
					{/foreach}

				</aside>


				<!-- Left side (main) -->
				<aside id="left">

					<!-- Main content boxes -->
					{$page}
				</aside>

				<!-- Clear the float to make it expand the box -->
				<div class="clear"></div>
			</section>
		</div>

			<footer>
				<div class="headline">&copy; Copyright {date("Y")} {$serverName}</div>
				<b>Theme by <a href="{$url}" target="_blank">{$serverName}</a>
				| Powered by <a href="https://github.com/FusionGen" target="_blank">FusionGEN</a></b>
			</footer>
		</div>

	</body>
</html>