{$head}

	<body>


			<header>
				<a href="{$url}"><div class="headline"></div></a>
			</header>

		<div class="slider">
		</div>

		<div id="wrapper">
			<!-- Navigation menu -->
			<nav>
				<ul>
					{foreach from=$menu_top item=menu_1}
						<li><a {$menu_1.link}>{$menu_1.name}</a></li>
					{/foreach}
				</ul>

				<!-- Clear the float to make it expand the box -->
				<div class="clear"></div>
			</nav>

			<!-- Main website area -->
			<section id="main">

				<!-- Right side (sideboxes)-->
				<aside id="right">

					<!-- Side menu -->
					<article>
						<div class="headline">Menu</div>
						<div class="content" id="menu">
							<ul>
								{foreach from=$menu_side item=menu_2}
									<center><li><div class="hvr-underline-from-center"><a {$menu_2.link}>{$menu_2.name}</a></div></li></center>
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

					<article id="slider_wrapper" {if !$show_slider}style="display:none;"{/if}>
						<div id="slider">
							{foreach from=$slider item=image}
								<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
							{/foreach}
						</div>
					</article>

					<!-- Main content boxes -->
					{$page}
				</aside>

				<!-- Clear the float to make it expand the box -->
				<div class="clear"></div>
			</section>

			<footer>
				<div class="headline">&copy; Copyright {date("Y")} {$serverName}</div>
				Theme by <a href="https://www.gitlab.com/omghixd/fusiongen" target="_blank">OMGhixD</a>
				</br></br>Powered by <center><a href="https://gitlab.com/omghixd/fusiongen"><div class="fgen"></div></a></center>
			</footer>
		</div>

	</body>
</html>