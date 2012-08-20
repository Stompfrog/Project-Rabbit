<div class="page-header">
	<h1>Artify.co</h1>
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
								<li><a href="<?= $message['message_url'] ?>"><img src="<?= $message['profile_image']->get_profile_thumb_path() ?>" /></a></li>
							<?php } else { ?>
								<li><a href=""><img class="thumbnail" src="http://placehold.it/60x60" alt="" /></a></li>
							<?php } ?>
						</ul>
						<h3><a href="<?= $message['message_url'] ?>"><?= $message['first_name'] . ' ' . $message['last_name'] ?></a></h3>
						<p><?= $message['message'] ?></p>
				    </li>
					<?php
				}
			} else
				echo '<li>there are no messages</li>';
			?>
			</ul>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>