<section class="box big" id="donate_articles">
	<h2>
		Visitors in the past 5 minutes ({count($sessions)})
	</h2>

	<ul>
		{if $sessions}
			{foreach from=$sessions item=visitor}
				<li>
					<table width="100%">
						<tr>
							<td width="15%">
								{date("H:i:s", $visitor.last_activity)}
							</td>

							<td width="20%">
								{if isset($visitor.nickname)}
									<a href="{$smarty.const.pageURL}profile/{$visitor.user_id}" target="_blank">{$visitor.nickname}</a>
								{else}
									Guest
								{/if}
							</td>

							<td>
								{$visitor.ip_address}
							</td>

							<td width="20%">
								<img src="{$smarty.const.pageURL}application/images/browsers/{$visitor.browser}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.browser)}
							</td>

							<td width="20%">
								<img src="{$smarty.const.pageURL}application/images/platforms/{$visitor.os}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.os)}
							</td>
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>