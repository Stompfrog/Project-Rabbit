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
						<li class="active"><a href="index.html">Home</a></li>
						<li><a href="explore.html">Explore</a></li>
						<li><a href="artists.html">Artists</a></li>
						<li><a href="groups.html">Groups</a></li>
						<li><a href="places.html">Places</a></li>
						<li><a href="events.html">Events</a></li>
					</ul>
					<form action="" class="pull-right">
						<a href="<?php echo base_url(); ?>/index.php/auth/login" class="btn primary" type="submit">Sign in</a>
						<a class="btn primary" href="reg1.html" type="submit">Register</a>
					</form>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="content">
