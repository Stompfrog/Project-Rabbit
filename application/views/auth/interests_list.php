<?php
$submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'class' => 'btn primary'
);
?>
<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Interests</h2>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<?php 
				if (isset($interests)) { 
					foreach ($interests as $interest) {
						$data = array(
						    'name'        => $interest['title'],
						    'id'          => $interest['id'],
						    'value'       => $interest['id']
						    );
						if (!is_null($interest['user_id'])) 
							$data['checked'] = TRUE;
						echo '<div class="clearfix">';
						echo form_label($interest['title'], $interest['id']);
						echo form_checkbox($data);
						echo '</div>';
					}
				} else {
					echo '<p>No interests</p>';
				} ?>
	        </fieldset>
			<div class="actions">
				<?php echo form_submit($submit, 'Update interests'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>	
</div>