{if isset($is404) && $is404}
	<center style='margin:10px;font-weight:bold;'>{lang("404_long", "error")}</center>
{else}
	<center style='margin:10px;font-weight:bold;'>{$errorMessage}</center>
{/if}