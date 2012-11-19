<?php /******************************************************************************************
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
	*******************************************************************************************/ ?>
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
        $data = array();
        $data['friends'] = $friends;
        $data['total_friends'] = $total_friends;
        $data['pending_friends'] = $pending_friends;
        $data['user_id'] =  $user->get_id();
        $this->load->view('templates/friends', $data);
	?>
</div>