<ul class="media-grid pull-left">
	<?php if ($user->get_large_avatar('class="profile_image"')) { ?>
	<li><a href="<?= site_url() . '/artists/' . $user->get_id() . '">' . $user->get_large_avatar('class="profile_image"'); ?></a></li>
	<?php } ?>
</ul>