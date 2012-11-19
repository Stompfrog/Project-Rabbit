<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
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
								<li><a href="<?= $message['message_url'] ?>"><?= $message['profile_image']->get_thumb_image() ?></a></li>
							<?php } else { ?>
								<li><a href=""><img class="thumbnail" src="http://placehold.it/60x60" alt="" /></a></li>
							<?php } ?>
						</ul>
						<h3><a href="<?= $message['message_url'] ?>"><?= $message['first_name'] . ' ' . $message['last_name'] ?></a></h3>
						<p><?= $message['message'] ?></p>
				    </li>
					<?php
				}
			} else {
				echo '<li>there are no messages</li>';
			} ?>
			</ul>

	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>