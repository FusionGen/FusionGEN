{include file="{$theme_path}config/global.tpl" scope="parent"}
{include file="{$theme_path}views/header.tpl" scope="parent"}

	<body class="gb ltr theme-heaven version-1.0.0">		
		{include file="{$theme_path}views/parts/header.tpl"}
		
		{if $show_slider}{include file="{$theme_path}views/parts/slider.tpl"}{/if}
		
		<!-- Main Section.Start -->
		<section class="section section-page" page>
			{$showSidebox = in_array($moduleName, $sidebox_modules)}
			{if isset($is404) && in_array("errors", $sidebox_modules)}{$showSidebox = true}{/if}
			<div class="container">
				<div class="row g-3">
					<!-- Main.Start -->
					<div class="col-lg-12" main>
						<div class="row">
							<div class="col{if $showSidebox}-lg-8{/if} py-5">
								{$page}
							</div>

							{if $showSidebox}
								<div class="col-lg-4 py-lg-5 pb-5 pb-lg-0">
									{include file="{$theme_path}views/parts/sidebox.tpl"}
								</div>
							{/if}
						</div>
					</div>
				</div>
			</div>
			
		</section>
		<!-- Main Section.End -->
	
		{include file="{$theme_path}views/parts/footer.tpl"}
	
	</body>
</html>