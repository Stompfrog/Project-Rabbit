<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1>
</div>
<div class="row">
	<div class="span10">
		<h2><?= $user->get_status(); ?></h2>
		<p><?= $user->get_about_me(); ?></p>
		<dl>
			<dt>Website</dt>
			<dd><?= anchor($user->get_website(),$user->get_website()); ?></dd>
		</dl>
		
		<?php
		$interests = $user->get_interests_list();
		if($interests != null) {
			echo '<h4>Interests</h4>';
			echo $interests;
		} ?>

		<?php
			if (isset($galleries) && $galleries) {
				?><h4>Galleries</h4>
				<ul class="media-grid">'<?php		
				foreach ($galleries as $gallery) {
					echo '<li><a href="' . $gallery->get_url() . '" title="' . $gallery->get_title() . '">' . $gallery->get_thumb() . '</a></li>';
				}
				echo '</ul>';
					
				if ($logged_in_user) { ?>
					<ul>
						<li><a href="<?= base_url() ?>index.php/admin/galleries/add_gallery/">Add a gallery</a></li>
					</ul>
				<?php }
			}
			
			if ($images != null && sizeof($images) > 0) {
				echo '<h4>Images</h4>';
				echo '<ul class="media-grid">';
				foreach ($images as $image) {
					echo '<li><a href="' . base_url() . 'index.php/artists/' . $user->get_id() . '/image/' . $image->get_id() . '/" title="' . $image->get_title() . '">' . $image->get_thumb_image() . '</a></li>';						
				}
				echo '</ul>';
			} else {
				echo '<p>No images yet</p>';
			}
			
			
			if ($logged_in_user) { ?>
				<ul>
					<li><a href="<?= base_url() ?>index.php/admin/images/add_image">Upload an image</a></li>
				</ul>
			<?php }
		?>

	</div>

	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
	
</div>