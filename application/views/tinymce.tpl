<script type="text/javascript">
	require(["{$url}application/js/tiny_mce/jquery.tinymce.js"], function()
	{
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '{$url}application/js/tiny_mce/tiny_mce.js',

			height: "300",

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,formatselect,fontselect,fontsizeselect,charmap,emotions,iespell,media,|,fullscreen,bullist,numlist,removeformat",
			theme_advanced_buttons2 : "outdent,indent,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,tablecontrols,|,visualaid",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>