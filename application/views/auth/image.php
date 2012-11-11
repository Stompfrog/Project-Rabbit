<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your Images</h2>
		<hr />
		<div class="span10">
		<?php
		if (isset($images)) {
			echo '<ul class="image-grid">';
			foreach ($images as $image) {
				echo '<li class="image_list"><dl>';
				echo '<dt><a href="' . base_url() . 'index.php/admin/images/image/' . $image->get_id() . '">' . $image->get_thumb_image() . '</a></dt>';
				echo '<dd><a href="' . base_url() . 'index.php/admin/images/delete_image/' . $image->get_id() . '" class="btn danger small" style="margin: 8px;">Delete image</a></dd>';
				echo '</dl></li>';
			}
			echo '</ul>';
		} else {
			echo 'you do not have any images';
		}
		?>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>