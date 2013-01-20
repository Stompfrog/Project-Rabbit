<div class="span4">
	<?php
		//profile image
		$this->load->view('templates/profile_image', $user);

		//if the user is logged in, and this is the users profile
		if ($logged_in_user) { ?>
			<a href="<?= site_url() ?>admin/images/profile_images">Upload/edit profile picture</a>
	<?php } ?>
	<hr />
	<?php
		if ($this->tank_auth->is_logged_in()) {
			$message_data['user_id'] = $user->get_id();
			$this->load->view('templates/message', $message_data);
		}
		echo '<hr/>';
		
		if ($user->get_addresses()) {
			echo '<h3><a href="/addresses/">Addresses</a></h3>';
			echo $user->get_addresses();
		} else {
			if ($logged_in_user) {
				echo '<h3><a href="/addresses/">Addresses</a></h3>';
				echo '<p>You have not added any addresses. You maynot be found by other artists in your area.</p>'; 
				echo '<p>' . anchor('/addresses/add_address/', 'Add address') . '</p>'; 			
			} else {
				echo 'No addresses';
			}
		}

		$group_data['groups'] = $user->get_groups();
		if ($logged_in_user) {
			echo '<h3><a href="' . site_url() . 'artists/' . $user->get_id() . '/groups/">Groups</a></h3>';
			$this->load->view('templates/groups', $group_data);
			echo '<p>' . anchor('groups/create/', 'Create group') . '</p>';
		} else {
			echo '<h3>Groups</h3>';
			$this->load->view('templates/groups', $group_data);
		}
		echo '<hr/>';
		if ($logged_in_user) {
			echo '<h3><a href="' . site_url() . 'admin/images/">Images</a></h3>';
			echo '<ul class="artists unstyled">';
			echo '	<li>' . anchor('/admin/images/add_image/', 'Add image') . '</li>';
			echo '	<li>' . anchor('/admin/images/profile_images/', 'View and add profile images') . '</li>';
			echo '</ul>';
		} else {
			echo '<h3><a href="' . site_url() . 'artists/' . $user->get_id() . '/images">Images</a></h3>';
		}
		echo '<hr/>';
		if ($logged_in_user) {
			echo '<h3><a href="' . site_url() . 'admin/galleries/">Galleries</a></h3>';
			echo '<p>' . anchor('admin/galleries/add_gallery/', 'Add gallery') . '</p>';
		}
		echo '<hr/>';
        $data = array();
        $data['friends'] = $friends;
        $data['total_friends'] = $total_friends;
        $data['pending_friends'] = $pending_friends;
        $data['user_id'] =  $user->get_id();
        $this->load->view('templates/friends', $data);
        
        if ($logged_in_user) { ?>
			<h3><a href="/admin/interests/">Interests</a></h3>
			<h3><a href="/admin/events/">Events</a></h3>
			<ul class="events unstyled">
				<li><?php echo anchor('events/add_event/', 'Add event'); ?></li>
			</ul>
		<?php } else {
			//get user interest cloud
		} ?>
</div>