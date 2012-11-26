<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your Messages</h2>
		<hr />
		<div class="span10">
			<ul class="search-results">
			<?php
			if (isset($messages)) {
				foreach ($messages as $message) {
					?>
					<li>
						<ul class="media-grid">
							<?php
								if (isset($message['profile_image'])) { ?>
							<li><a href="" title="<?= $message['first_name'] . ' ' . $message['last_name'] ?>"><?= $message['profile_image']->get_profile_thumb_image('style="width: 60px; height: 60px; "') ?></a></li>
							<?php } else {
							?><li><a href="" title="<?= $message['first_name'] . ' ' . $message['last_name'] ?>"><img class="thumbnail" src="http://placehold.it/60x60" alt="" /></a></li><?php
							} ?>
						</ul>
						<p><?= $message['message'] ?></p>
				    </li>
					<?php
				}
			} else
				echo '<li>there are no messages</li>';
			?>
			</ul>
			
			<?php if (isset($message_form)) echo $message_form ?>
				
		</div>
	</div>

	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>