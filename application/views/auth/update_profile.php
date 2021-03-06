<?php
$first_name = array(
	'name'  => 'first_name',
	'id'    => 'first_name',
	'value' => set_value('first_name', $table_values['first_name']),
	'maxlength'     => 30,
	'size'  => 10,
);
$last_name = array(
	'name'  => 'last_name',
	'id'    => 'last_name',
	'value' => set_value('last_name', $table_values['last_name']),
	'maxlength'     => 30,
	'size'  => 20,
);
$about_me = array(
	'name'  => 'about_me',
	'id'    => 'about_me',
	'value' => set_value('about_me', $table_values['about_me']),
	'size'  => 30,
);
$sex = array(
	'id'    => 'sex',
	'value' => set_value('sex', $table_values['sex'])
);
$website = array(
    'name'  => 'website',
    'id'    => 'website',
    'value' => set_value('website', $table_values['website']),
    'maxlength'     => 80,
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

		<h2>Basic Information</h2>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<div class="clearfix">
				    <?php echo form_label('First name', $first_name['id']); ?>
				    <div class="input">
			            <?php echo form_input($first_name); ?>
			            <?php echo form_error($first_name['name']); ?>
			            <?php echo isset($errors[$first_name['name']])?$errors[$first_name['name']]:''; ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('Last name', $last_name['id']); ?>
				    <div class="input">
			            <?php echo form_input($last_name); ?>
			            <?php echo form_error($last_name['name']); ?><?php echo isset($errors[$last_name['name']])?$errors[$last_name['name']]:''; ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('About me', $about_me['id']); ?>
				    <div class="input">
			            <?php echo form_textarea($about_me); ?>
			            <?php echo form_error($about_me['name']); ?><?php echo isset($errors[$about_me['name']])?$errors[$about_me['name']]:''; ?>
				    </div>
				</div>
				
<!--
				<div class="clearfix">
				    <?php echo form_label('Address', $address['id']); ?>
				    <div class="input">
				    	<?php echo form_input($address); ?>
				    </div>
				</div>
				<div id="map" style="width:100%; height:300px; margin-bottom: 20px; "></div>
				<div class="clearfix">
				    <?php echo form_label('Latitude', $lat['id']); ?>
				    <div class="input">
				    	<?php echo form_input($lat); ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('Longitude', $lon['id']); ?>
				    <div class="input">
				    	<?php echo form_input($lon); ?>
				    </div>
				</div>
-->
				
				<div class="clearfix">
				    <?php echo form_label('Website', $website['id']); ?>
				    <div class="input">
				    	<?php echo form_input($website); ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php 
						$options = array(
						'o' => 'Prefer not to say',
						'm' => 'Male',
						'f' => 'Female'
						);
					?>
				    <?php echo form_label('Sex', $sex['id']); ?>
				    <div class="input">
				    	<?php echo form_dropdown('sex', $options, $sex['value'], 'id="sex"'); ?>
				    </div>
				</div>
	        </fieldset>
			<div class="actions">
				<?php echo form_submit($submit, 'Update profile'); ?>
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