<?php

$group_name = array(
	'name'  => 'group_name',
	'id'    => 'group_name',
	'value' => set_value('group_name'),
	'maxlength' => 100,
	'size'  => 30,
);
$description = array(
	'name'  => 'description',
	'id'    => 'description',
	'value' => set_value('description'),
	'size'  => 30,
);
$submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'class' => 'btn primary'
);
?>
<div class="page-header">
	<h1>Groups</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Create a new group</h2>
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
				<?php echo form_submit($submit, 'Create group'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>