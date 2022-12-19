<div class="row">
	<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" data-bs-target="#general" href="#general" data-bs-toggle="tab">General</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-bs-target="#system" href="#system" data-bs-toggle="tab">System info</a>
			</li>
		</ul>
	
		<div class="tab-content">
			<div class="tab-pane active" id="general">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="h3 fw-bold fst-italic"><span class="text-primary">V</span>{$version}</h3>
						{if $update && count($writeableList) <= 0}
							{if ($update.available)}
								<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="UpdateCMS.update(this)"><i class="fas fa-sync fa-spin"></i> Update</a>
							{/if}
						{/if}
					</div>
					<div class="col-sm-9 align-self-center">
						<h4 class="h4 fw-bold">FusionGen Update System</h4>
						
						<p>
							<span class="fw-bold text-primary"><i class="fa-solid fa-triangle-exclamation"></i> Warning:</span>
							<ul>
								<li>When the cms is updated the configuration can be restored to the default depending on the changes made to each version.</li>
								<li>All your files needs write permission!</li>
							</ul>
						</p>
						{if count($writeableList) > 0}
								<h4>The following files need write permissions for the updater to work completely.:</h4>
							<ul>
								{foreach from=$writeableList item=file}
									<li>{$file.path}</li>
								{/foreach}
							</ul>
						{else}
							{if $update}
								{if ($update.available)}
									<h5  class="h5 fw-bold">
										{count($update.versions)}
										update{if count($update.versions) > 1}s{/if} is available:
									</h5>
									
									<ul>
									{foreach from=$update.versions item=version key=key}
										<li>{$version}</li>
									{/foreach}
									</ul>
									
								{else}
										No updates is available
								{/if}
							{/if}
							<span id="updatelog" rows="10"></span>
						{/if}
					</div>
				</div>
			</div>
			<div class="tab-pane" id="system">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">PHP Version</label>
					<div class="col-sm-9 align-self-center">
						{$php_version}
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">CodeIgniter Version</label>
					<div class="col-sm-9 align-self-center">
						{$ci_version}
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">CMS Version</label>
					<div class="col-sm-9 align-self-center">
						{$version}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">System hostname</label>
					<div class="col-sm-9 align-self-center">
						{$system_hostname}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">Server Software</label>
					<div class="col-sm-9 align-self-center align-self-center">
						{$server_software}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">allow_url_fopen</label>
					<div class="col-sm-9 align-self-center align-self-center">
						{if $allow_url_fopen}
							<span class="badge badge-success">On</span>
						{else}
							<span class="badge badge-danger">Off</span>
						{/if}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">allow_url_include</label>
					<div class="col-sm-9 align-self-center align-self-center">
						{if $allow_url_include}
							<span class="badge badge-success">On</span>
						{else}
							<span class="badge badge-danger">Off</span>
						{/if}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">Apache Modules</label>
					<div class="col-sm-9 align-self-center">
						{if $ApacheModules}
							{$ApacheModules}
						{else}
							<span>PHP-FPM used. Not possible to fetch Apache Modules!</span>
						{/if}
					</div>
				</div>
	
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="name">PHP Extensions</label>
					<div class="col-sm-9 align-self-center mt-1">
						{foreach from=$php_extensions item=extensions}
							{$extensions}
						{/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>