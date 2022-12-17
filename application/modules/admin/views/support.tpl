<div class="row">
<div class="col-lg-4 mb-3">
<div class="card">
	<header class="card-header"> 
		<h2 class="card-title">Help</h2>
	</header>
	<div class="card-body">
	<div class="accordion accordion-quaternary" id="accordionHelp">
		<div class="card card-default">
			<div class="card-header">
				<h4 class="card-title m-0">
					<a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordionHelp" data-bs-target="#collapseOne" aria-expanded="false">
						How does it work?
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="collapse" data-bs-parent="#accordionHelp" style="">
				<div class="card-body">
					<p>You make a request (button) and then the data is collected and sent to the supporter on the FusionGen site.</p>
				</div>
			</div>
		</div>
		<div class="card card-default">
			<div class="card-header">
				<h4 class="card-title m-0">
					<a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordionHelp" data-bs-target="#collapseTwo">
						Is sensitive data transmitted?
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="collapse" data-bs-parent="#accordionHelp">
				<div class="card-body">
					<p>Absolutely not. No sensitive data will be transmitted.</p>
				</div>
			</div>
		</div>
		<div class="card card-default">
			<div class="card-header">
				<h4 class="card-title m-0">
					<a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordionHelp" data-bs-target="#collapseThree">
						Which data is transmitted?
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="collapse" data-bs-parent="#accordionHelp">
				<div class="card-body">
					<p>General data such as e.g. domain, enabled and disabled modules, IP, PHP version, web server (apache/nginx), homepage error logs.</p>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>

<div class="col-lg-8">
<div class="card">
	<header class="card-header"> 
		<div class="card-actions">
			<button class="btn btn-primary btn-sm pull-right" href="javascript:void(0)" onClick="Support.create()">Create request</button>
		</div>
		<h2 class="card-title">Support reports</h2>
	</header>
	<div class="card-body">
		<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Created</th>
			</tr>
		</thead>
		<tbody>
		{if $supportrequests}
			{foreach from=$supportrequests item=request}
				<tr>
					<td>{$request.id}</td>
					<td>{date("Y-m-d H:i:s", $request.timestamp)}</td>
				</tr>
			{/foreach}
		{/if}
		</tbody>
		</table>
	</div>
</div>
</div>
</div>