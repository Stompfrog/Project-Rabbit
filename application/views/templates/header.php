<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Project Rabbit</title>
		<link rel="stylesheet" href="<?= base_url(); ?>/css/bootstrap.css">		
		<link rel="stylesheet" href="<?= base_url(); ?>/css/style.css" />
	</head>
	<body>
	
		<div class="topbar">
			<div class="fill">
				<div class="container">
					<a class="brand" href="<?= base_url(); ?>">Project Rabbit</a>
					<ul class="nav">
						<li class="active"><a href="<?= base_url(); ?>">Home</a></li>
						<li><a href="<?= base_url(); ?>index.php/explore/">Explore</a></li>
						<li><a href="<?= base_url(); ?>index.php/artists/">Artists</a></li>
						<li><a href="<?= base_url(); ?>index.php/groups/">Groups</a></li>
						<li><a href="<?= base_url(); ?>index.php/places/">Places</a></li>
						<li><a href="<?= base_url(); ?>index.php/events/">Events</a></li>
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
									<li><?php echo anchor('auth/update_profile','Edit Profile'); ?></li>
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
