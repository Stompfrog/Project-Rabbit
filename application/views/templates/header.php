<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Artify.co</title>
		<link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.css">		
		<link rel="stylesheet" href="<?= base_url(); ?>css/style.css" />
	</head>
	<body>
		<div class="topbar">
			<div class="fill">
				<div class="container">
					<a class="brand" href="<?= site_url(); ?>">Artify.co</a>
					<ul class="nav">
						<li <?php if($this->uri->segment(1)=="welcome" || !$this->uri->segment(1)){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>">Home</a></li>
						<li <?php if($this->uri->segment(1)=="explore"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>explore/">Explore</a></li>
						<li <?php if($this->uri->segment(1)=="artists"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>artists/">Artists</a></li>
						<li <?php if($this->uri->segment(1)=="groups"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>groups/">Groups</a></li><?php /*
						<li <?php if($this->uri->segment(1)=="places"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>places/">Places</a></li>
						<li <?php if($this->uri->segment(1)=="events"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>events/">Events</a></li> */ ?>
						<li <?php if($this->uri->segment(1)=="api"){ echo "class='active' "; } ?>><a href="<?= site_url(); ?>api/">API</a></li>
					</ul>
					<ul class="nav secondary-nav">
						<?php if ($this->tank_auth->is_logged_in()) { ?>
							<?php 
								$user_id = $this->tank_auth->get_user_id();
								$user_name = $this->tank_auth->get_username();
							?>

							<li class="dropdown" data-dropdown="dropdown">
								<?php echo anchor('artists/render',$user_name,'class="dropdown-toggle"'); ?>
								<ul class="dropdown-menu">
									<li><?php echo anchor('artists/'.$user_id,'View Profile'); ?></li>
									<li><?php echo anchor('admin/profile','Edit Profile'); ?></li>
									<li><?php echo anchor('admin/images/profile_images','Add profile image'); ?></li>
									<li class="divider"></li>
									<li><?php echo anchor('auth/logout','Log out'); ?></li>
								</ul>
				            </li>
						<?php }else{ ?>
							<li><?php echo anchor('auth/login','Log in'); ?></li>
							<li><?php echo anchor('auth/register','Register'); ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="content">