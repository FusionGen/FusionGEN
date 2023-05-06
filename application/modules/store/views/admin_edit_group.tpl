<div class="card">
	<div class="card-header"><a href='{$url}store/admin_items' data-bs-toggle="tooltip" data-placement="top" title="Return">Groups</a> &rarr; Edit group</div>
	<div class="card-body">
		<form onSubmit="Items.editGroup({$group.id}, this); return false">
			<div class="form-group row">
				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="title">Group name</label>
					<input class="form-control" type="text" name="title" id="title" value="{$group.title}">
				</div>

				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="order" data-bs-toggle="tooltip" data-placement="top" title="Specify an order, it will be sorted ascending by group order">Group order</label>
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
						<div class="input-group">
							<input class="spinner-input form-control" type="text" name="order" id="order" value="{$group.orderNumber}">
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fas fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fas fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-sm">Edit group</button>
		</form>
	</div>
</div>