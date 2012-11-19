<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
	<?php if (isset($gallery)) { ?>
		<h2><?= $gallery['title'] ?></h2>
		<hr />
		<div class="span10">
			<p><?= $gallery['description'] ?></p>
			<hr />
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
			
			if ($logged_in_user) {
				echo form_open_multipart('/auth/add_profile_image'); ?>
				<div class="control-group">
				    <?php echo form_label('Upload image', 'upload_img'); ?>
				    <div class="controls">
				    	<?php echo form_upload('userfile'); ?>
				    </div>
				</div>
				<?php echo form_submit('upload', 'Upload');
				echo form_close();
				echo '<p><a href="' . site_url() . '/artists/' . $user->get_id() . '/edit_gallery/' . $gallery['id'] . '">Edit gallery</a></p>';
			} else if (isset($error)) {
				echo '<p>' . $error . '</p>';
			} ?>
		</div>
		<?php } ?>
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>