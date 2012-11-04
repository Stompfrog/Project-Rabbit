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
			echo '<ul class="media-grid">';
			foreach ($images as $image) {
				echo '<li>' . $image->get_image_link() . '</li>';
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