<div class="wrapper">
	<section class="container-fluid inner-page">
		<div class="row">
			<div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-12 full-dark-bg">
				<!-- Files section -->
				<form class="dropzone files-container">
					<div class="fallback">
					<i class="fa-solid fa-cloud-arrow-up"></i>
						<input name="module" id="module" type="file">
					</div>
				</form>

				<span>Only ZIP file type is supported.</span>

				<h4 class="section-sub-title"><span>Uploaded</span> module</h4>
				<span class="no-files-uploaded">No modules uploaded yet.</span>

				<div class="preview-container dz-preview uploaded-files">
					<div id="previews">
						<div id="FGEN-dropzone-template">
							<div class="FGEN-dropzone-info">
								<div class="details">
									<div>
										<span data-dz-name></span> <span data-dz-size></span>
									</div>
									<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
									<div class="dz-error-message"><span data-dz-errormessage></span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="alert alert-danger" role="alert">
	Third-party modules are not supported! Use at your own risk<br>
	You can download tested modules <a href="https://fusiongen.net/marketplace/" class="alert-link" target="_blank">here</a>
</div>

<script>
    Dropzone.autoDiscover = false;
	$(window).on('load', function() {
		FGEN.init();
	});
</script>

<div class="row">
	<div class="col-lg-6 mb-3">
		<div class="card">
			<header class="card-header"> 
				<div class="card-actions">
					<span class="badge badge-success align-right" id="enabled_count">{count($enabled_modules)}</span>
				</div>
				<h2 class="card-title">Installed modules</h2>
			</header>
			<div class="card-body p-0">
				<table class="table m-0">
					<tbody id="enabled_modules">
						{foreach from=$enabled_modules item=module key=key}
							<tr class="border-top">
								<td class="font-weight-bold border-0 w-70 align-middle text-light">{ucfirst($module.name)} <span class="font-weight-normal">by</span> <a href="{$module.author.website}" target="_blank">{$module.author.name}</a><br><small class="font-weight-normal" style="color:#97989d;">{$module.description}</small></td>
								<td class="pull-right">
									<div class="btn-group">
										<button type="button" class="btn btn-primary">Action</button>
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												{if hasPermission("toggleModules")}
													<a href="javascript:void(0)" onClick="Modules.disableModule('{$key}', this);" class="dropdown-item text-danger">Disable</a>
												{/if}
												{if $module.has_configs && hasPermission("editModuleConfigs")}
													<a href="{$url}admin/edit/{$key}" class="dropdown-item">Edit Configs</a>
												{/if}
											</div>
										</div>
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<header class="card-header"> 
				<div class="card-actions">
					<span class="badge badge-danger align-right" id="disabled_count">{count($disabled_modules)}</span>
				</div>
				<h2 class="card-title">Disabled modules</h2>
			</header>
			<div class="card-body p-0">
				<table class="table m-0">
					<tbody id="disabled_modules">
						{foreach from=$disabled_modules item=module key=key}
							<tr class="border-top">
								<td class="font-weight-bold border-0 w-70 align-middle text-light">{ucfirst($module.name)} <span class="font-weight-normal">by</span> <a href="{$module.author.website}" target="_blank">{$module.author.name}</a><br><small class="font-weight-normal" style="color:#97989d;">{$module.description}</small></td>
								<td class="pull-right">
									<div class="btn-group">
										<button type="button" class="btn btn-primary">Action</button>
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												{if hasPermission("toggleModules")}
													<a href="javascript:void(0)" onClick="Modules.enableModule('{$key}', this);" class="dropdown-item text-success">Enable</a>
												{/if}
												{if $module.has_configs && hasPermission("editModuleConfigs")}
													<a href="{$url}admin/edit/{$key}" class="dropdown-item">Edit Configs</a>
												{/if}
											</div>
										</div>
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
