<section class="box big" id="main_link">
	<h2>
		Supported languages (<div style="display:inline;" id="logs_count">{if !$languages}0{else}{count($languages)}{/if}</div>)
	</h2>

	<ul id="log_list">
	{if $languages}
		{foreach from=$languages item=language key=flag}
			<li>
				<div style="float:right">
					{if $language == $default}
						<div style="color:green">Default language</div>
					{elseif hasPermission("changeDefaultLanguage")}
						<a class="nice_button" href="javascript:void(0)" onClick="Languages.set('{$language}')">Set as default</a>
					{/if}
				</div>

				<img src="{$url}application/images/flags/{$flag}.png" alt="{$flag}"> {ucfirst($language)}
			</li>
		{/foreach}
	{/if}
	</ul>

	<span>
		<center><b>Want more?</b> Get more languages from the <a href="https://github.com/raxezdev/FusionCMS-Localization" target="_blank">localization GitHub repository</a></center>
	</span>
</section>