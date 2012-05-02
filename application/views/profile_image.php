<html>
<head>
<title>Upload Profile Image</title>
</head>
<body>
<?php
	if (isset($result['success']))
		echo '<p>successfully uploaded</p>';
	else if (isset($error))
		echo $error;

	echo form_open_multipart('up/profile_image'); ?>
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
	
	
</body>
</html>
