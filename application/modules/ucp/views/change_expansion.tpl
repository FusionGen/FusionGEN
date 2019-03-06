{form_open('ucp/expansion', 'class="page_form"')}
	<table style="width:80%">
		<tr>
			<td><label for="expansion">{lang("expansion", "ucp")}</label></td>
			<td>
				<select id="expansion" name="expansion">
					{foreach from=$expansions key=id item=expansion}
						<option value="{$id}" {if $my_expansion == $id}selected{/if}>{lang(strtolower($expansion), "ucp")}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table>
	<center style="margin-bottom:10px;">
		<input type="submit" name="change_submit" value="{lang("change_expansion", "ucp")}" />
	</center>
</form>