<div class="card" id="add_item">
	<div class="card-header"><a href='{$url}store/admin_items' data-toggle="tooltip" data-placement="top" title="Return">Groups</a> &rarr; New group</div>
	<div class="card-body">
		<form onSubmit="Items.create(this, true); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="title">Group name</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="title" id="title" />
			</div>
			</div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="order" data-tip="Specify an order, it will be sorted ascending by group order">Group order</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="order" id="order" />
			</div>
			</div>

			<button type="submit" class="btn btn-primary btn-sm">Submit group</button>
		</form>
	</div>
</div>