<?php

$group_name = array(
	'name'  => 'group_name',
	'id'    => 'group_name',
	'value' => set_value('group_name', $table_values['group_name']),
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
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
		<h2>Edit group</h2>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<div class="clearfix">
				    <?php echo form_label('Group name', $group_name['id']); ?>
				    <div class="input">
			            <?php echo form_input($group_name); ?>
			            <?php echo form_error($group_name['name']); ?>
			            <?php echo isset($errors[$group_name['name']])?$errors[$group_name['name']]:''; ?>
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
				<?php echo form_submit($submit, 'Update group'); ?>
			</div>
		<?php echo form_close(); ?>	
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>