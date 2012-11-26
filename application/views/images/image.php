<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
	<?php if (isset($image)) { ?>
		<h2><?= $image->get_title() ?></h2>
		<hr />
		<div class="span10">
			<?=  $image->get_large_image('style="width: 100%; height: auto;"'); ?>			
		</div>
		<?php if (isset($image)) { ?>
		<p><?= $image->get_description() ?></p>
		<?php } ?>
		<?php
			if ($logged_in_user) { ?>
				<p><a href="<?= site_url() ?>artists/<?= $user->get_id() ?>/edit_image/<?= $image->get_id() ?>">Edit image</a></p>
			<?php } else if (isset($error)) {
				echo '<p>' . $error . '</p>';
			}
		} else {
			echo '<p>No image available</p>';
		} ?>
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>