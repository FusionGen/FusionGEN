<script src="{$url}application/modules/ucp/js/jquery.dm-uploader.min.js"></script>

<div class="mb-3 dm-uploader"  id="drag-and-drop-zone">
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 text-center">
		<img class="rounded-circle mb-3" src="{$avatar}" width="153px" height="153px"><br>
		<button class="nice_button" href="javascript:void(0)" onClick="Avatar.remove()">Delete avatar</button>
	</div>

	<div class="file-upload dm-uploader">
		<button class="file-upload-btn" type="button" onClick="$('.file-upload-input').trigger('click')">Add Image</button>
		<small class="status text-muted"></small>
	
		<div class="image-upload-wrap" id="drag-and-drop-zone">
			<input class="file-upload-input" type='file' accept="image/*">
			<div class="drag-text">
				<h3>Drag and drop a file or select add Image</h3>
			</div>
		</div>
	
		<div class="file-upload-content mt-3">
			<input type="text" class="image-upload-wrap" aria-describedby="fileHelp" readonly="readonly">
	
			<div class="progress mb-2 d-none">
				<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0">
					0%
				</div>
			</div>
		</div>
	</div>
</div>
</div>

{if $debug}
<div class="row">
	<div class="col-12">
		<div class="card h-100">
			<div class="card-header">
				Debug Messages
			</div>

			<ul class="list-group list-group-flush" id="debug">
			</ul>
		</div>
	</div>
</div>
{/if}

<script type="text/javascript">
$(function(){
  $('#drag-and-drop-zone').dmUploader({ //
    url: '{$url}ucp/avatar/upload',
    maxFileSize: 2000000, 
    multiple: false,
    allowedTypes: 'image/*',
    extFilter: ['jpg','jpeg','png','gif'],
	extraData: {
		csrf_token_name: Config.CSRF
	},
    onDragEnter: function(){
      this.addClass('active');
    },
    onDragLeave: function(){
      this.removeClass('active');
    },
    onInit: function(){
      ui_add_log('Initialized :)', 'info');

      this.find('input[type="text"]').val('');
    },
    onComplete: function(){
      ui_add_log('All pending tranfers finished');
    },
    onNewFile: function(id, file){
      ui_add_log('New file added #' + id);

      if (typeof FileReader !== "undefined"){
        var reader = new FileReader();
        var img = this.find('img');
        
        reader.onload = function (e) {
          img.attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
      }
    },
    onBeforeUpload: function(id){
      ui_add_log('Starting the upload of #' + id);
      ui_single_update_progress(this, 0, true);      
      ui_single_update_active(this, true);

      ui_single_update_status(this, 'Uploading...');
    },
    onUploadProgress: function(id, percent){
	  $('.image-upload-wrap').hide();
	  $('.file-upload-content').show();
      ui_single_update_progress(this, percent);
    },
    onUploadSuccess: function(id, data){
      var response = JSON.stringify(data);

      ui_add_log('Server Response for file #' + id + ': ' + response);
      ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');

      ui_single_update_active(this, false);

      //this.find('input[type="text"]').val(response);
      $('.file-upload-content').hide();
	  $('.image-upload-wrap').show();

      ui_single_update_status(this, 'Upload completed.', 'success');
    },
    onUploadError: function(id, xhr, status, message){
      ui_single_update_active(this, false);
      ui_single_update_status(this, 'Error: ' + message, 'danger');
    },
    onFallbackMode: function(){
      ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
    },
    onFileSizeError: function(file){
      ui_single_update_status(this, 'File excess the size limit', 'danger');

      ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
    },
    onFileTypeError: function(file){
      ui_single_update_status(this, 'File type is not an image', 'danger');

      ui_add_log('File \'' + file.name + '\' cannot be added: must be an image (type error)', 'danger');
    },
    onFileExtError: function(file){
      ui_single_update_status(this, 'File extension not allowed', 'danger');

      ui_add_log('File \'' + file.name + '\' cannot be added: must be an image (extension error)', 'danger');
    }
  });
});
</script>

<script type="text/html" id="debug-template">
	<li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
</script>