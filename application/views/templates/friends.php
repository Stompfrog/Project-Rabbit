<?php
if (isset($friends) && sizeof($friends) > 0)
{?>
	<h3>Friends</h3>        
	<ul class="events unstyled">
	<?php foreach($friends as $fr)
	{
		echo '<li><a href="' . $fr['id'] . '"> ' . $fr['name'] . '</a></li>';
	} ?>
	</ul>
<?php
} else {
	echo '<p>No friends yet</p>';
}

//if the user is logged in
//if the current user is not viewing their own page
	//if they are already friends
		//show 'already friends' message
	//if this user has requested viewing user to be friends
		//show confirm friends link

if ($this->tank_auth->is_logged_in()) {
	//if this isn't the logged in user
	if($this->tank_auth->get_user_id() != $user_id) {
		if (isset($already_friends) && $already_friends) {
			echo '<p>You are already friends</p>';
		} else if (isset($friend_requested_reverse) && $friend_requested_reverse) {
			echo '<p><a href="' . base_url() . 'index.php/api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Confirm friend</a></p>';
		} else { //not friends, so
			//has a friend request already been sent?
			if (isset($friend_requested) && isset($user_id)) {
				if ($friend_requested) {
					echo '<p class="alert-success">friend request pending<p>';
				} else {
					echo '<p><a href="' . base_url() . 'index.php/api/addfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Add as friend</a></p>';
				}
			} else {
				echo '<p><a href="' . base_url() . 'index.php/api/addfriend/' . $this->tank_auth->get_user_id() . '/' . $user_id . '/" class="btn success friend">Add as friend</a></p>';
			}
		}
	//if current user viewing his own profile
	} else if ($this->tank_auth->get_user_id() == $user_id) {
		if (isset($pending_friends) && sizeof($pending_friends) > 0)
		{
			echo '<h3>Pending friends</h3>';
			echo '<ul class="friends unstyled">';
			foreach ($pending_friends as $p_f) {
				echo '<li><a href="' . $p_f['id'] . '">' . $p_f['name'] . ' <span><a href="' . base_url() . 'index.php/api/confirmfriend/' . $this->tank_auth->get_user_id() . '/' . $p_f['id'] . '/" class="btn success friend">Confirm friend</a></span></li>';
			}
			echo '</ul>';
		}
	}
}
?>