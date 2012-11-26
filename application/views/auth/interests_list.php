<?php
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
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>