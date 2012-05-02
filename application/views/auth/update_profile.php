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
	'maxlength'     => 80,
	'size'  => 30,
);
$sex = array(
	'id'    => 'sex',
	'value' => set_value('sex', $table_values['sex'])
);
$address = array(
	'name'  => 'address',
	'id'    => 'address',
	'value' => set_value('address'),
	'maxlength'     => 100,
	'size'  => 30,
);
$lat = array(
    'name'  => 'lat',
    'id'    => 'lat',
    'value' => set_value('lat'),
    'maxlength'     => 40,
    'size'  => 30,
);
$lon = array(
    'name'  => 'lon',
    'id'    => 'lon',
    'value' => set_value('lon'),
    'maxlength'     => 40,
    'size'  => 30,
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
<div class="page-header">
	<h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Edit your profile</h2>
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
	<div class="span4">
		<h3>Other options</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/artists/' . $this->tank_auth->get_user_id(), 'View profile'); ?></li>
			<li><?php echo anchor('/auth/change_password/', 'Change password'); ?></li>
			<li><?php echo anchor('/auth/logout/', 'Logout'); ?></li>
			<li><?php echo anchor('/auth/unregister/', 'Unregister'); ?></li>
		</ul>
	</div>
</div>