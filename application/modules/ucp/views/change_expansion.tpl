{form_open('ucp/expansion', 'class="page_form"')}
	<table style="width:90%">
		<tr>
			<td style="width:25% !important"><label for="expansion">{lang("expansion", "ucp")}</label></td>
			<td>
				<select id="expansion" name="expansion">
					{foreach from=$expansions key=id item=expansion}
						<option value="{$id}" {if $my_expansion == $id}selected{/if}>{$expansion}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table>
	<center>
		<input class="btn btn-primary mt-2" type="submit" name="change_submit" value="{lang("change_expansion", "ucp")}" />
	</center>
</form>