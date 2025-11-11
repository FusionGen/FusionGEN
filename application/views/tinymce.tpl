<script>
    require([
		"{$url}application/js/tiny_mce/tinymce.min.js"
	], function () {
		tinymce.init({
			promotion: false,

			selector : "textarea",

			height: 400,

			skin: 'oxide-dark',
			content_css: 'dark',

			/* display statusbar */
			statusbar: false,

			plugins: 'preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help code',
			toolbar: 'undo redo | blocks | formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment | code',
			image_advtab: true
		});
    });
</script>
