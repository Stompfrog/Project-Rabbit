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
		<ul class="events unstyled">
			<li><?php echo anchor('/admin/addresses/', 'Your addresses'); ?></li>
			<li><?php echo anchor('/admin/addresses/add_address/', 'Add address'); ?></li>
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