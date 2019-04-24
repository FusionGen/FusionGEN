<script type="text/javascript">
    require(["{$url}application/js/tiny_mce/jquery.tinymce.min.js"], function () {
        if($('textarea.tinymce').tinymce() != null) {
            $('textarea.tinymce').tinymce().remove();
        }
        $('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url: '{$url}application/js/tiny_mce/tinymce.min.js',

            /* width and height of the editor */

            width: 670,
            height: 400,

            /* display statusbar */
            statubar: false,

            // General options
            theme: "modern",
            skin: "lightgray",

            plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor",
            toolbar: "insertfile | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor emoticons",

        });
    });
</script>