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
$address_1 = array(
	'name'  => 'address_1',
	'id'    => 'address_1',
	'value' => set_value('address_1', $table_values['address_1']),
	'maxlength' => 100,
	'size'  => 30,
);
$address_2 = array(
	'name'  => 'address_2',
	'id'    => 'address_2',
	'value' => set_value('address_2', $table_values['address_2']),
	'maxlength' => 100,
	'size'  => 30,
);
$city = array(
	'name'  => 'city',
	'id'    => 'city',
	'value' => set_value('city', $table_values['city']),
	'maxlength' => 100,
	'size'  => 30,
);
$postcode = array(
    'name'  => 'postcode',
    'id'    => 'postcode',
    'value' => set_value('postcode', $table_values['postcode']),
    'maxlength'     => 10,
    'size'  => 10,
);
$lat = array(
    'name'  => 'lat',
    'id'    => 'lat',
    'value' => set_value('lat', $table_values['lat']),
    'maxlength'     => 40,
    'size'  => 30,
);
$lon = array(
    'name'  => 'lon',
    'id'    => 'lon',
    'value' => set_value('lon', $table_values['lon']),
    'maxlength'     => 40,
    'size'  => 30,
);
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
		<h2>Your addresses</h2>
		
		<ul>
			<li>Add address</li>
		</ul>
		<hr />
		<?php if (isset($message)) { echo $message; } ?>
		<?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
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
				<!--
				<div class="clearfix">
				    <?php echo form_label('Address', $address['id']); ?>
				    <div class="input">
				    	<?php echo form_input($address); ?>
				    </div>
				</div>
				-->
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
				<?php echo form_submit($submit, 'Update address'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>