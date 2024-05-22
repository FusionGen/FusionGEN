<div class="row">
	<div class="col">
		<section class="card">
			<header class="card-header">
				<div class="card-actions">
					<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
					<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
				</div>

				<h2 class="card-title">Sent Email log</h2>
			</header>
			<div class="card-body">
				<table class="table table-bordered table-striped mb-0" id="emaillogs">
					<thead>
						<tr>
							<th>#</th>
							<th>User</th>
							<th>Email</th>
							<th>Subject</th>
							<th>Time</th>
							<th>Message</th>
							<th class="d-none"></th>
						</tr>
					</thead>
					<tbody>
					{if $emaillogs}
						{foreach from=$emaillogs item=log}
							<tr>
								<td>{$log.id}</td>
								<td>{$CI->user->getUsername($log.uid)}</td>
								<td>{$log.email}</td>
								<td>{$log.subject}</td>
								<td>{date("Y-m-d H:i:s", $log.timestamp)}</td>
								<td>{character_limiter($log.message, 20)}</td>
								<td class="d-none">{$log.message}</td>
							</tr>
						{/foreach}
					{/if}
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>

<script>
(function($) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#emaillogs');

		// initialize
		var datatable = $table.dataTable({
			dom: '<"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
		});

	};

	$(function() {
		datatableInit();
	});

}).apply(this, [jQuery]);
</script>
