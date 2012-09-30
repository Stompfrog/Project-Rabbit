<div class="page-header">
	<h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h2>
		<hr />
		<h3><?= $user->get_status(); ?></h3>
		<p><?= $user->get_about_me(); ?></p>
		<dl>
			<dt>Website</dt>
			<dd><?= anchor($user->get_website(),$user->get_website()); ?></dd>
		</dl>
		<h4>Interests</h4>
		<?=  $user->get_interests_list(); ?>
		
		<h4>Portfolio</h4>
		<ul class="media-grid">
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
		</ul>
	</div>
	<div class="span4">
		<ul class="media-grid pull-left">
			<?php /*
			//old gravatar icon
			<li><a href="#"><img src="http://www.gravatar.com/avatar/<?= md5( strtolower( trim( $user->get_email() ) ) )?>?s=210" /></a></li> */ ?>
			<?php if ($user->get_large_avatar()) { ?>
			<li><a href="#"><?= $user->get_large_avatar() ?></a></li>
			<?php } ?>
		</ul>
		<?php 
		//if the user is logged in, and this is the users profile
		if ($this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id()) { ?>
			<a href="<?= base_url() ?>index.php/auth/add_profile_image">Upload/edit profile picture</a>
		<?php } ?>
		<hr />
		<? if($user->get_addresses()) {
			echo '<h3>Addresses</h3>';
			echo $user->get_addresses();
		}
		
		$group_data['groups'] = $user->get_groups();
		$this->load->view('templates/groups', $group_data);
		?>

		<?php
	        $data = array();
	        $data['friends'] = $friends;
	        $data['total_friends'] = $total_friends;
	        $data['pending_friends'] = $pending_friends;
	        $data['user_id'] =  $user->get_id();
	        $this->load->view('templates/friends', $data);
		?>
	</div>
</div>