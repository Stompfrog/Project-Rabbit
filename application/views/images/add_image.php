<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
	
		<h2>Add Image</h2>
		<hr />
		<?php
		if (isset($success))
			echo '<img src="' . $success . '" />';
		else if (isset($error))
			echo $error;
	
		echo form_open_multipart('/admin/images/add_image'); ?>
		<div class="control-group">
		    <div class="controls">
		    	<?php echo form_upload('userfile'); ?>
		    </div>
		</div>
		<?php echo form_submit('upload', 'Upload'); ?>
		<?php echo form_close(); ?>
		
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>