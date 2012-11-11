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
<div class="page-header">
	<h1>Galleries</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Edit gallery</h2>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
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
		<?php echo form_close(); ?>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>