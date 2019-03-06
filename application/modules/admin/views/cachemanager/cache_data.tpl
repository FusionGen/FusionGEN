<li>
	<table width="100%">
		<tr>
			<td width="50%">Item cache</td>
			<td id="row_item">{$item.files} files ({$item.sizeString})</td>
		</tr>
	</table>
</li>

<li>
	<table width="100%">
		<tr>
			<td width="50%">Website cache</td>
			<td id="row_website">{$website.files} files ({$website.sizeString})</td>
		</tr>
	</table>
</li>

<li>
	<table width="100%">
		<tr>
			<td width="50%">Private message cache</td>
			<td id="row_message">{$message.files} files ({$message.sizeString})</td>
		</tr>
	</table>
</li>

<li>
	<table width="100%">
		<tr>
			<td width="50%"><b>Total</b></td>
			<td id="row_total"><b>{$total.files} files ({$total.size})</b></td>
		</tr>
	</table>
</li>