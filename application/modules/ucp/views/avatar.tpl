    <div class="avatar">
        <img src="{$avatar}" alt="avatar" width="120" height="120">
    </div>
    <p>Maximum files size allowed {$max_size} kb.</p>
    	<p>Max width and height {$max_width} * {$max_height}</p>
    		<p>Allowed types : {$allowed_types}</p>
    	{form_open_multipart('ucp/avatar/upload')}
        	<label for="avatar">Select a file to upload : </label>
        		<input name="avatar" id="avatar" type="file">
			<div class="clear"></div>
        	<center><input value="Upload" type="submit"></center>
    	{form_close()}
</section> 