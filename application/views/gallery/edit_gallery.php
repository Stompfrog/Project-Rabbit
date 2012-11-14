<?php
$gallery_name = array(
	'name'  => 'title',
	'id'    => 'title',
	'value' => set_value('title', $table_values['title']),
	'maxlength' => 100,
	'size'  => 30,
);
$description = array(
	'name'  => 'description',
	'id'    => 'description',
	'value' => set_value('description', $table_values['description']),
	'size'  => 30,
);
$submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'class' => 'btn primary'
);
?>
<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
		<h2></h2>
		<hr />
		<div class="span10">
		<?php
			if ($logged_in_user) {
				if (isset($message)) { echo $message; }
					echo form_open($this->uri->uri_string()); ?>
					<fieldset>
						<div class="clearfix">
						    <?php echo form_label('Gallery name', $gallery_name['id']); ?>
						    <div class="input">
					            <?php echo form_input($gallery_name); ?>
					            <?php echo form_error($gallery_name['name']); ?>
					            <?php echo isset($errors[$gallery_name['name']])?$errors[$gallery_name['name']]:''; ?>
						    </div>
						</div>
						<div class="clearfix">
						    <?php echo form_label('Description', $description['id']); ?>
						    <div class="input">
					            <?php echo form_textarea($description); ?>
					            <?php echo form_error($description['name']); ?>
					            <?php echo isset($errors[$description['name']])?$errors[$description['name']]:''; ?>
						    </div>
						</div>
			        </fieldset>
					<div class="actions">
						<?php echo form_submit($submit, 'Update gallery'); ?>
					</div>
				<?php echo form_close();
			} else if (isset($error)) {
				echo '<p>' . $error . '</p>';
			} ?>
		</div>
	</div>
	<div class="span4">
		<ul class="media-grid pull-left">
			<?php if ($user->get_large_avatar()) { ?>
			<li><a href="#"><?= $user->get_large_avatar('class="profile_image"') ?></a></li>
			<?php } ?>
		</ul>
		<?php 
		//if the user is logged in, and this is the users profile
		if ($logged_in_user) { ?>
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
		
		<h3>Images</h3>
		<p><a href="<?= base_url() ?>index.php/artists/<?= $user->get_id() ?>/images">All images</a></p>

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