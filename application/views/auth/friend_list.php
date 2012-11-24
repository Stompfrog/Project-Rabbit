<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Friend list</h2>
		<hr />
		<div class="span10">
		<?php if (isset($pending_friends) && sizeof($pending_friends) > 0) { ?>
	     	<h3>Pending friends</h3>
			<ul class="friends unstyled">
			<?php foreach($pending_friends as $fr)
			{
				echo '<li><a href="' . $fr['id'] . '">' . $fr['name'] . ' <span><a href="' . site_url() . 'api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $fr['id'] . '/" class="btn success friend">Confirm friend</a></span></li>';
			} ?>
			</ul><?php
		}
/*
		//all friends
		if (isset($friends) && sizeof($friends) > 0) { ?>
	     	<h3>Friends</h3>
			<ul class="events unstyled">
			<?php foreach($friends as $fr)
			{
				echo '<li>' . $fr['name'] . ' <a href="' . site_url() . 'api/unfriend/' . $this->tank_auth->get_user_id() . '/' . $fr['id'] . '/" class="btn danger friend">Unfriend</a></li>';
			} ?>
			</ul><?php
		
		} else
			echo '<h3>No friends at the moment</h3>';
*/
		?>
		
		<?php 
		if (isset($friends_paginated)) {
			echo '<ul class="events unstyled">';
			foreach($friends_paginated as $fr)
			{
				echo '<li>' . $fr['name'] . ' <a href="' . site_url() . 'api/unfriend/' . $this->tank_auth->get_user_id() . '/' . $fr['id'] . '/" class="btn danger friend">Unfriend</a></li>';
			} ?>
			</ul><?php
		}
		?>
		<?php if (isset($pagination)) echo $pagination; ?>
		<?php
		if (isset($pag)) {
		    echo $pag;
		}
		?>
		
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>