<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
	<?php if (isset($gallery)) { ?>
		<h2><?= $gallery['title'] ?></h2>
		<p><?= $gallery['description'] ?></p>
		<hr />
		<div class="span10">
			<?php
			if ($gallery['images'] != null && sizeof($gallery['images']) > 0) {
				echo '<ul class="media-grid">';
				foreach ($gallery['images'] as $image) {
					echo '<li>' . $image->get_image_link() . '</li>';
				}
				echo '</ul>';
			} else {
				echo '<p>No images yet</p>';
			}
			?>
		</div>
		<?php echo form_open_multipart('/auth/add_profile_image'); ?>
		<div class="control-group">
		    <?php echo form_label('Upload image', 'upload_img'); ?>
		    <div class="controls">
		    	<?php echo form_upload('userfile'); ?>
		    </div>
		</div>
		<?php echo form_submit('upload', 'Upload'); ?>
		<?php echo form_close(); ?>
		<?php } else if (isset($error)) {
			echo '<p>' . $error . '</p>';
		} else {
			echo '<p>No images yet</p>';
		} ?>		
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>