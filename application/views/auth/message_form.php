<?php
$message = array(
	'name'  => 'message',
	'id'    => 'message',
	'value' => set_value('message'),
	'size'  => 30,
);
$submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'class' => 'btn primary'
);
?>
<div class="row">
	<div class="span10">
		<?php if (isset($error)) { echo $error; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<div class="clearfix">
				    <?php echo form_label('Message', $message['id']); ?>
				    <div class="input">
			            <?php echo form_textarea($message); ?>
			            <?php echo form_error($message['name']); ?><?php echo isset($errors[$message['name']])?$errors[$message['name']]:''; ?>
				    </div>
				</div>
	        </fieldset>
			<div class="actions">
				<?php echo form_submit($submit, 'Send'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>