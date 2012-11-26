<?php
//If user is logged in, link to messages
if ($this->tank_auth->is_logged_in() && isset($user_id)) {
	//if viewing users own profule, 
	if($user_id === $this->tank_auth->get_user_id()) {
		echo '<h3>Messages</h3>';
		echo '<a href="' . site_url() . 'messages">View messages</a></p>';
	} else {
		//display send message link
		echo '<h2>Message</h2>';
		echo '<p><a href="' . site_url() . 'artists/'  . $user_id . '/message/">Message</a></p>';
	}
}