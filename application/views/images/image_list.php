<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
		<?php
		if (isset($images)) {
			echo '<ul class="image-grid">';
			foreach ($images as $image) {
				echo '<li class="image_list"><dl>';
				echo '<dt><a href="' . site_url() . 'admin/images/image/' . $image->get_id() . '">' . $image->get_thumb_image() . '</a></dt>';
				echo '<dd><a href="' . site_url() . 'api/images/profile/' . $image->get_id() . '" class="btn success small" style="margin: 8px;">Set as profule image</a></dd>';
				echo '<dd><a href="' . site_url() . 'admin/images/edit_image/' . $image->get_id() . '" class="btn success small ajax" style="margin: 8px;">Edit image</a></dd>';
				echo '<dd><a href="' . site_url() . 'admin/images/delete_image/' . $image->get_id() . '" class="btn danger small" style="margin: 8px;">Delete image</a></dd>';
				echo '</dl></li>';
			}
			echo '</ul>';
		} else {
			echo 'you do not have any images';
		}
		?>	
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>