<div class="realm-st-holder">
	{foreach from=$realms item=realm}
		<div class="realm-st">
			<div class="realm-{strtolower(get_class($realm->getEmulator()))}">
				<div class="realm-info">
					<strong class="realm-name">{$realm->getName()}</strong>
					{if $realm->isOnline()}
						<span class="realm-status online"><span style="color: #8edc44;">ONLINE</span></span>
					{else}
						<span class="realm-status offline"><span style="color: #dc5944;">OFFLINE</span></span>
					{/if}
				</div>
			</div>
		</div>
	{/foreach}
</div>

<section class="realmlist-info box">
	<div class="body">
		<div class="realmlist">
			set realmlist {$realmlist}
			</div>
	</div>
</section>

<script type="text/javascript">
	// The cleanest way, but hacky :/
	$('.realmlist-info.box').insertAfter($('.realmlist-info.box').parents('.box').addClass('type-status')).css('display', 'block');
</script>