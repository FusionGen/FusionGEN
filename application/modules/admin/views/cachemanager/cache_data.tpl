<div class="card">
	<div class="card-body table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Cache</th>
				<th>Size</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Item cache</td>
			<td id="row_item">{$item.files} files ({$item.sizeString})</td>
		</tr>
		<tr>
			<td>Website cache</td>
			<td id="row_website">{$website.files} files ({$website.sizeString})</td>
		</tr>
		<tr>
			<td class="fw-bold">Total</td>
			<td class="fw-bold" id="row_total">{$total.files} files ({$total.size})</td>
		</tr>
		</tbody>
	</table>
	</div>
</div>
