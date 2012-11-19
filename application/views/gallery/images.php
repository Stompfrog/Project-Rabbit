<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
		<?php if (isset($images)) { ?>
			<h2>All Images</h2>
			<hr />
			<div class="span10">
				<?php
				if ($images != null && sizeof($images) > 0) {
					echo '<ul class="media-grid">';
					foreach ($images as $image) {
						echo '<li><a href="' . base_url() . 'index.php/artists/' . $user->get_id() . '/image/' . $image->get_id() . '/" title="' . $image->get_title() . '">' . $image->get_thumb_image() . '</a></li>';						
					}
					echo '</ul>';
				} else {
					echo '<p>No images yet</p>';
				}
				?>
			</div>
			<?php } else if (isset($error)) {
				echo '<p>' . $error . '</p>';
			} else {
				echo '<p>No images yet</p>';
			} ?>

	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>