<?php
if (isset($friends) && sizeof($friends) > 0)
{?>
	<h3>Friends <?php if (isset($total_friends)) echo '(' . $total_friends . ')'; ?></h3>        
	<ul class="events unstyled">
	<?php foreach($friends as $fr) {
		echo '<li><a href="' .  site_url() . 'artists/' . $fr['id'] . '"> ' . $fr['name'] . '</a></li>';
	} ?>
	</ul>
<?php
} else {
	echo '<p>No friends yet</p>';
}
	
//if the user is logged in and not viewing their own page
if ($this->tank_auth->is_logged_in()) {
	//if this isn't the logged in user
	if($this->tank_auth->get_user_id() != $user_id) {
		//if they are already friends
		if (isset($already_friends) && $already_friends) {
			//show 'already friends' message
			echo '<p><a href="' . site_url() . 'api/unfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn danger friend">Unfriend</a></p>';
		} else if (isset($friend_requested_reverse) && $friend_requested_reverse) {
			echo '<p><a href="' . site_url() . 'api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Confirm friend</a></p>';
		} else { //not friends, so
			//has a friend request already been sent?
			if (isset($friend_requested) && isset($user_id)) {
				if ($friend_requested) {
					echo '<p class="alert-success">friend request pending<p>';
				} else {
					//show confirm friends link
					echo '<p><a href="' . site_url() . 'api/addfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Add as friend</a></p>';
				}
			} else {
				echo '<p><a href="' . site_url() . 'api/addfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Add as friend</a></p>';
			}
		}
	//if current user viewing his own profile
	} else if ($this->tank_auth->get_user_id() == $user_id) {
		if (isset($pending_friends) && sizeof($pending_friends) > 0)
		{
			echo '<h3>Pending friends</h3>';
			echo '<ul class="friends unstyled">';
			foreach ($pending_friends as $p_f) {
				echo '<li><a href="' . $p_f['id'] . '">' . $p_f['name'] . ' <span><a href="' . site_url() . 'api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $p_f['id'] . '/" class="btn success friend">Confirm friend</a></span></li>';
			}
			echo '</ul>';
		}
	}
}
?>