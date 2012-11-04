<div class="page-header">
	<h1>Images</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Add Image</h2>
		<hr />
		<?php
		if (isset($success))
			echo '<img src="' . $success . '" />';
		else if (isset($error))
			echo $error;
	
		echo form_open_multipart('/admin/images/add_image'); ?>
		<div class="control-group">
		    <div class="controls">
		    	<?php echo form_upload('userfile'); ?>
		    </div>
		</div>
		<?php echo form_submit('upload', 'Upload'); ?>
		<?php echo form_close(); ?>
	
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>