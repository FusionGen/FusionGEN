<div class="alert alert-info alert-dismissible fade show" role="alert">
	Each template must contain $message in pure php format.<br>It contains the text of the email that was defined in the sendMail function in the controller.<br><br>Available variables:<br>$username<br>$message<br>$url
</div>

<form onSubmit="Template.save({$template.id}); return false">
	<div class="card pb-3">
		<div class="card-header">Template</div>
			<div class="card-body">
				<textarea rows="10" class="form-control" id="code" name="code" data-plugin-codemirror>{$content}</textarea>
			</div>
		</div>
	</div>
<input class="btn btn-primary btn-sm" type="submit" value="Save">
</form>

<div class="card mt-3">
	<div class="card-header">Preview</div>
	<div class="card-body">
		<iframe id="preview" style='height: 100%; width: 100%;' frameborder="0" scrolling="auto"></iframe>
	</div>
</div>

<script>
  var delay;
  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    mode           : "htmlmixed",
    theme          : "ayu-mirage",
    tabSize        : 2,
    indentUnit     : 2,
    indentWithTabs : false,
    lineNumbers    : true,
  });
  editor.on("change", function() {
	clearTimeout(delay);
    delay = setTimeout(updatePreview, 300);
  });
  
  function updatePreview() {
    var previewFrame = document.getElementById('preview');
    var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
    preview.open();
    preview.write(editor.getValue());
    preview.close();
  }
  setTimeout(updatePreview, 300);
</script>

<script>
    // Selecting the iframe element
    var iframe = document.getElementById("preview");
    
    // Adjusting the iframe height onload event
    iframe.onload = function(){
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
    }
</script>
