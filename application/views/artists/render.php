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
				?><h4>Galleries</h4>
				<ul class="media-grid">'<?php		
				foreach ($galleries as $gallery) {
					echo '<li><a href="' . $gallery->get_url() . '" title="' . $gallery->get_title() . '">' . $gallery->get_thumb() . '</a></li>';
				}
				echo '</ul>';
					
				if ($logged_in_user) { ?>
					<ul>
						<li><a href="<?= base_url() ?>index.php/admin/galleries/add_gallery/">Add a gallery</a></li>
					</ul>
				<?php }
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
					<li><a href="<?= base_url() ?>index.php/admin/images/add_image">Upload an image</a></li>
				</ul>
			<?php }
		?>

	</div>
	<?php
	/******************************************************************************************
		<div class="span4">
		<h3>Your account</h3>
		<ul class="events unstyled">
			<li><?= anchor('/artists/' . $this->tank_auth->get_user_id(), 'View profile'); ?></li>
			<li><?= anchor('/admin/messages/', 'Messages'); ?></li>
			<li><?= anchor('/auth/change_password/', 'Change password'); ?></li>
			<li><?= anchor('/auth/unregister/', 'Unregister'); ?></li>
		</ul>
		<h3>Friends</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/friends/', 'Friends'); ?></li>
		</ul>
		<h3>Interests</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/interests/', 'Your interests'); ?></li>
		</ul>
		<h3>Address/s</h3>
		<h3>Images</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/images/', 'Your images'); ?></li>
			<li><?php echo anchor('/admin/images/add_image/', 'Add image'); ?></li>
			<li><?php echo anchor('/admin/images/profile_images/', 'View and add profile images'); ?></li>
		</ul>
		<h3>Galleries</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/galleries/', 'Your galleries'); ?></li>
			<li><?php echo anchor('/admin/galleries/add_gallery/', 'Add gallery'); ?></li>
		</ul>
		<h3>Groups</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/groups/', 'Your groups'); ?></li>
			<li><?php echo anchor('/admin/groups/create_group/', 'Create group'); ?></li>
		</ul>
		<h3>Events</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/events/', 'Your events'); ?></li>
			<li><?php echo anchor('/admin/groups/add_event/', 'Add event'); ?></li>
		</ul>
	</div>
	*******************************************************************************************/
	?>
	<div class="span4">

		<?php
			//profile image
			$this->load->view('templates/profile_image', $user);
		?>

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
		
		if ($logged_in_user) { ?>
			<ul class="events unstyled">
				<li><?php echo anchor('/admin/addresses/', 'Your addresses'); ?></li>
				<li><?php echo anchor('/admin/addresses/add_address/', 'Add address'); ?></li>
			</ul>
		<?php }
		
		$group_data['groups'] = $user->get_groups();
		$this->load->view('templates/groups', $group_data);
		if ($logged_in_user) { ?>
			<h3>Group admin</h3>
			<ul class="events unstyled">
				<li><?php echo anchor('/admin/groups/', 'Your groups'); ?></li>
				<li><?php echo anchor('/admin/groups/create_group/', 'Create group'); ?></li>
			</ul>
		<?php }
		?>
		
		<h3>Images</h3>
		<p><a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>/images">All images</a></p>

		<?php
			//if current user is not the user being viewed
			$this->load->view('templates/message', $user->get_id());
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