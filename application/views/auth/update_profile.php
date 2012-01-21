<?php
$first_name = array(
	'name'	=> 'first_name',
	'id'	=> 'first_name',
	'value'	=> set_value('first_name'),
	'maxlength'	=> 30,
	'size'	=> 10,
);
$last_name = array(
	'name'	=> 'last_name',
	'id'	=> 'last_name',
	'value'	=> set_value('last_name'),
	'maxlength'	=> 30,
	'size'	=> 20,
);
$about_me = array(
	'name'	=> 'about_me',
	'id'	=> 'about_me',
	'value'	=> set_value('about_me'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$country = array(
	'name'	=> 'country',
	'id'	=> 'country',
	'value'	=> set_value('country'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$website = array(
	'name'	=> 'website',
	'id'	=> 'website',
	'value'	=> set_value('website'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label('First name', $first_name['id']); ?></td>
		<td><?php echo form_input($first_name); ?></td>
		<td style="color: red;"><?php echo form_error($first_name['name']); ?><?php echo isset($errors[$first_name['name']])?$errors[$first_name['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Last name', $last_name['id']); ?></td>
		<td><?php echo form_input($last_name); ?></td>
		<td style="color: red;"><?php echo form_error($last_name['name']); ?><?php echo isset($errors[$last_name['name']])?$errors[$last_name['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('About me', $about_me['id']); ?></td>
		<td><?php echo form_textarea($about_me); ?></td>
		<td style="color: red;"><?php echo form_error($about_me['name']); ?><?php echo isset($errors[$about_me['name']])?$errors[$about_me['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Country', $country['id']); ?></td>
		<td><?php echo form_input($country); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Website', $website['id']); ?></td>
		<td><?php echo form_input($website); ?></td>
	</tr>
</table>
<?php echo form_submit('update_profile', 'Update profile'); ?>
<?php echo form_close(); ?>