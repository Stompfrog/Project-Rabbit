<?php
$is_venue = array(
	'name'  => 'is_venue',
	'id'    => 'is_venue',
	'value' => set_value('is_venue', 1)
);
$address_type = array(
	'name'  => 'address_type',
	'id'    => 'address_type',
	'value' => set_value('address_type', 1)
);
$address = array(
	'name'  => 'address',
	'id'    => 'address',
	'value' => set_value('address'),
	'maxlength' => 100,
	'size'  => 30,
);
$address_1 = array(
	'name'  => 'address_1',
	'id'    => 'address_1',
	'value' => set_value('address_1'),
	'maxlength' => 100,
	'size'  => 30,
);
$address_2 = array(
	'name'  => 'address_2',
	'id'    => 'address_2',
	'value' => set_value('address_2'),
	'maxlength' => 100,
	'size'  => 30,
);
$city = array(
	'name'  => 'city',
	'id'    => 'city',
	'value' => set_value('city'),
	'maxlength' => 100,
	'size'  => 30,
);
$postcode = array(
    'name'  => 'postcode',
    'id'    => 'postcode',
    'value' => set_value('postcode'),
    'maxlength'     => 10,
    'size'  => 10,
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

		<h2>Add Address</h2>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
			
				<div class="clearfix">
				    <?php echo form_label('Address search'); ?>
				    <div class="input">
				    	<?php echo form_input($address); ?>
				    </div>
				</div>
				<hr />
				<div class="clearfix">
				    <?php echo form_label('Address line 1', $address_1['id']); ?>
				    <div class="input">
			            <?php echo form_input($address_1); ?>
			            <?php echo form_error($address_1['name']); ?>
			            <?php echo isset($errors[$address_1['name']])?$errors[$address_1['name']]:''; ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('Address line 2', $address_2['id']); ?>
				    <div class="input">
			            <?php echo form_input($address_2); ?>
			            <?php echo form_error($address_2['name']); ?>
			            <?php echo isset($errors[$address_2['name']])?$errors[$address_2['name']]:''; ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('City', $city['id']); ?>
				    <div class="input">
			            <?php echo form_input($city); ?>
			            <?php echo form_error($city['name']); ?>
			            <?php echo isset($errors[$city['name']])?$errors[$city['name']]:''; ?>
				    </div>
				</div>
				<div class="clearfix">
				    <?php echo form_label('Postcode', $postcode['id']); ?>
				    <div class="input">
			            <?php echo form_input($postcode); ?>
			            <?php echo form_error($postcode['name']); ?>
			            <?php echo isset($errors[$postcode['name']])?$errors[$postcode['name']]:''; ?>
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
	        </fieldset>
			<div class="actions">
				<?php echo form_submit($submit, 'Add address'); ?>
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