<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1>
</div>
<div class="row">
	<div class="span10">
		<h2><?= $user->get_status(); ?></h2>
		<p><?= $user->get_about_me(); ?></p>
		<dl>
			<dt>Website</dt>
			<dd><?= anchor($user->get_website(),$user->get_website()); ?></dd>
		</dl>
		
		<?php
		$interests = $user->get_interests_list();
		if($interests != null) {
			echo '<h4>Interests</h4>';
			echo $interests;
		} ?>

		<?php
			if (isset($galleries) && $galleries) {
				echo '<h4>Galleries</h4>';
				echo '<ul class="media-grid">';		
				foreach ($galleries as $gallery) {
					echo '<li><a href="' . $gallery->get_url() . '" title="' . $gallery->get_title() . '">' . $gallery->get_thumb() . '</a></li>';
				}
				echo '</ul>';		
			}
			
			if ($images != null && sizeof($images) > 0) {
				echo '<h4>Images</h4>';
				echo '<ul class="media-grid">';
				foreach ($images as $image) {
					echo '<li><a href="' . base_url() . 'index.php/artists/' . $user->get_id() . '/image/' . $image->get_id() . '/" title="' . $image->get_title() . '">' . $image->get_thumb_image() . '</a></li>';						
				}
				echo '</ul>';
			} else {
				echo '<p>No images yet</p>';
			}
			
			
			if ($logged_in_user) { ?>
				<ul>
					<li><a href="<?= base_url() ?>index.php/admin/galleries/add_gallery/">Add a gallery</a></li>
					<li><a href="<?= base_url() ?>index.php/admin/images/add_image">Upload an image</a></li>
				</ul>
			<?php }
		?>

	</div>
	<div class="span4">
		<ul class="media-grid pull-left">
			<?php if ($user->get_large_avatar('class="profile_image"')) { ?>
			<li><a href="<?php echo site_url() . '/artists/' . $user->get_id() . '">' . $user->get_large_avatar('class="profile_image"'); ?></a></li>
			<?php } ?>
		</ul>
		<?php 
		//if the user is logged in, and this is the users profile
		if ($logged_in_user) { ?>
			<a href="<?= base_url() ?>index.php/admin/images/profile_images">Upload/edit profile picture</a>
		<?php } ?>
		<hr />
		
		<?php
			if ($this->tank_auth->is_logged_in()) {
				$message_data['user_id'] = $user->get_id();
				$this->load->view('templates/message', $message_data);
			}
		?>
		
		<?php if($user->get_addresses()) {
			echo '<h3>Addresses</h3>';
			echo $user->get_addresses();
		}
		
		$group_data['groups'] = $user->get_groups();
		$this->load->view('templates/groups', $group_data);
		?>
		
		<h3>Images</h3>
		<p><a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>/images">All images</a></p>

		<?php
			//if current user is not the user being viewed
			//$this->load->view('templates/message', $data);
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