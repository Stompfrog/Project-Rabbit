<?php

	/*
		get all avatar images, display in a grid. have edit/delete image button
	*/
	if (isset($profile_images)) {
	?><ul class="media-grid">
		<?= $profile_images ?>
	</ul><?php }

	if (isset($success))
		echo '<img src="' . $success . '" />';
	else if (isset($error))
		echo $error;

	echo form_open_multipart('/auth/add_profile_image'); ?>
	<div class="control-group">
	    <?php echo form_label('Profile image', 'profile_img'); ?>
	    <div class="controls">
	    	<?php echo form_upload('userfile'); ?>
	    </div>
	</div>
	<?php echo form_submit('upload', 'Upload'); ?>
	<?php echo form_close(); ?>
	
	<?php
	/*
		multiples
		<form method="post" action="uploader/go" enctype="multipart/form-data">  
		  <input type="file" name="userfile[]" /><br />  
		  <input type="file" name="userfile[]" /><br />  
		  <input type="file" name="userfile[]" /><br />  
		  <input type="file" name="userfile[]" /><br />  
		  <input type="file" name="userfile[]" /><br />  
		  <input type="submit" name="go" value="Upload!!!" />  
		</form>
	*/
	?>