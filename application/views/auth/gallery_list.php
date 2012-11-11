<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Galleries</h2>
		<hr />
		<div class="span10">
			<?php if (isset($galleries)) { ?>
			<ul class="image-grid">
				<?php
				foreach ($galleries as $gallery) {
					echo '<li class="image_list"><dl>';
					echo '<dt><a href="' . $gallery->get_admin_url() . '" title="' . $gallery->get_title() . '">' . $gallery->get_thumb() . '</a></dt>';
					echo '<dd><a href="' . base_url() . 'index.php/admin/galleries/delete_gallery/' . $gallery->get_id() . '" class="btn danger small" style="margin: 8px;">Delete gallery</a></dd>';
					echo '</dl></li>';
				}
				?>
			</ul>
			<?php } else {
				echo '<p>No galleries</p>';
			} ?>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>