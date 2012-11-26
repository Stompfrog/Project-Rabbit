<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">


	<div class="span10">
		<h2>Friend list</h2>
		<hr />
		<div class="span10">
		<?php 
		
		if (isset($pending_friends)) {
			if (sizeof($pending_friends) > 0) { ?>
		     	<h3>Pending friends</h3>
				<ul class="friends unstyled">
				<?php foreach($pending_friends as $fr)
				{
					echo '<li><a href="' . $fr['id'] . '">' . $fr['name'] . ' <span><a href="' . site_url() . 'api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $fr['id'] . '/" class="btn success friend">Confirm friend</a></span></li>';
				} ?>
				</ul><?php
			} else {
				echo '<p>No friends pending at the moment</p>';
			}
		}

		if ($total_friends > 0) {
			if (isset($friends_paginated)) {
				echo '<ul class="events unstyled">';
				foreach($friends_paginated as $fr)
				{
					echo '<li>' . $fr['name'] . ' <a href="' . site_url() . 'api/unfriend/' . $this->tank_auth->get_user_id() . '/' . $fr['id'] . '/" class="btn danger friend">Unfriend</a></li>';
				} ?>
				</ul><?php
			}
			
			if (isset($pagination)) {
				echo $pagination;
			}
			
			if (isset($pag)) {
			    echo $pag;
			} 
		} else {
			echo '<p>No friends yet</p>';
		} ?>
		
		</div>
	</div>

	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>



