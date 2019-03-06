<section id="checkout_info">
	
	<a href="javascript:void(0)" onClick="Store.Cart.pay()" class="nice_button button_right">{lang("checkout", "store")} &rarr;</a>

	<a href="javascript:void(0)" onClick="Store.Cart.back()" class="nice_button button_left">&larr; {lang("go_back", "store")}</a>

	{lang("buying", "store")} <b>{$count} items</b> {lang("total_of", "store")}
	
	{if $vp}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" /> <b>{$vp} {lang("vp", "store")}</b>{/if}
	{if $vp && $dp}and{/if}
	{if $dp}<img src="{$url}application/images/icons/coins.png" align="absmiddle" /> <b>{$dp} {lang("dp", "store")}</b>{/if}

	<div class="clear"></div>
</section>

{foreach from=$realms item=realm key=realmId}
	<a class="online_realm_button">
		{$realm.name}
	</a>

	<section class="realm_items">
		
		{foreach from=$realm.items item=item}
		
			<article class="store_item" id="checkout_item_{$item.id}">
				
				{if ($item.query && $item.query_need_character) || !$item.query}
					<section class="checkout_characters">
						{if $realm.characters}
							<select data-id="{$item.id}" data-available="1">
								{foreach from=$realm.characters item=character}
									<option value="{$character.guid}">{$character.name} (Lv{$character.level})</option>
								{/foreach}
							</select>
						{else}
							<div style="height:10px;"></div>
							<b>{lang("no_character", "store")}</b>
						{/if}
					</section>
				{/if}

				<img class="item_icon" src="https://wow.zamimg.com/images/wow/icons/medium/{$item.icon}.jpg" align="absmiddle" {if $item.tooltip}data-realm="{$item.realm}" rel="item={$item.itemid}"{/if}>
				<a {if $item.tooltip}href="{$url}item/{$item.realm}/{$item.itemid}" data-realm="{$item.realm}" rel="item={$item.itemid}"{/if} class="item_name q{$item.quality}">
					{$item.name}
				</a>
				<br />{$item.description}
				<div class="clear"></div>
			</article>
		{/foreach}
	</section>
{/foreach}