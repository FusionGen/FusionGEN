<script type="text/javascript">
	var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
	
    require([
		"{$url}application/js/tiny_mce/tinymce.min.js"
	], function () {
			tinymce.init({
				selector: 'textarea.tinymce',

				height: 400,
				
				skin: useDarkMode ? 'oxide-dark' : 'oxide',
				content_css: useDarkMode ? 'dark' : 'default',
				
				/* display statusbar */
				statubar: false,
				
				plugins: 'print preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern help',
				toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
				image_advtab: true
		});
    });
</script>