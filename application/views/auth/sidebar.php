	<div class="span4">
		<h3>Other options</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/artists/' . $this->tank_auth->get_user_id(), 'View profile'); ?></li>
		</ul>
		<h3>Address</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/auth/address/', 'Your addresses'); ?></li>
			<li><?php echo anchor('/auth/add_address/', 'Add address'); ?></li>
		</ul>
		<h3>Your account</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/auth/change_password/', 'Change password'); ?></li>
			<li><?php echo anchor('/auth/logout/', 'Logout'); ?></li>
			<li><?php echo anchor('/auth/unregister/', 'Unregister'); ?></li>
		</ul>
	</div>