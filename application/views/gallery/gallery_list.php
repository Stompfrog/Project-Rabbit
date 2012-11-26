<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
		<h2>Galleries</h2>
		<hr />
		<?php if (isset($galleries)) { ?>
		<ul class="image-grid">
			<?php
			foreach ($galleries as $gallery) {
				echo '<li class="image_list"><dl>';
				echo '<dt><a href="' . $gallery->get_admin_url() . '" title="' . $gallery->get_title() . '">' . $gallery->get_thumb() . '</a></dt>';
				echo '<dd><a href="' . site_url() . 'admin/galleries/delete_gallery/' . $gallery->get_id() . '" class="btn danger small" style="margin: 8px;">Delete gallery</a></dd>';
				echo '</dl></li>';
			}
			?>
		</ul>
		<?php } else {
			echo '<p>No galleries</p>';
		} ?>
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>