<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<h1><a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>"><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></a></h1>
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
	<div class="span4">
		<ul class="media-grid pull-left">
			<?php if ($user->get_large_avatar()) { ?>
			<li><a href="#"><?= $user->get_large_avatar() ?></a></li>
			<?php } ?>
		</ul>
		<?php 
		//if the user is logged in, and this is the users profile
		if ($logged_in_user) { ?>
			<a href="<?= base_url() ?>index.php/admin/profile/add_profile_image">Upload/edit profile picture</a>
		<?php } ?>
		<hr />
		<? if($user->get_addresses()) {
			echo '<h3>Addresses</h3>';
			echo $user->get_addresses();
		}
		
		$group_data['groups'] = $user->get_groups();
		$this->load->view('templates/groups', $group_data);
		?>

		<?php
	        $data = array();
	        $data['friends'] = $friends;
	        $data['total_friends'] = $total_friends;
	        $data['pending_friends'] = $pending_friends;
	        $data['user_id'] =  $user->get_id();
	        $this->load->view('templates/friends', $data);
		?>
	</div>
</div>