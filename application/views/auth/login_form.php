<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember')
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
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
		<h2>Log in</h2>
		<hr />
		<?php echo form_open($this->uri->uri_string()); ?>
	        <fieldset>
				<div class="clearfix">
					<?php echo form_label($login_label, $login['id']); ?>
					<div class="input">
						<?php echo form_input($login); ?>
						<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
					</div>
				</div>
				<div class="clearfix">					
					<?php echo form_label('Password', $password['id']); ?>
					<div class="input">
						<?php echo form_password($password); ?>
						<?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
					</div>
				</div>
				<div class="clearfix">
					<?php echo form_label('Remember me', $remember['id']); ?>
					<div class="input">
						<ul class="inputs-list">
							<li>
								<label>
									<?php echo form_checkbox($remember); ?>
									<span>Stay logged in when you close the browser</span>
								</label>
							</li>
						</ul>
					</div>
				</div>			
				<div class="clearfix">		
				</div>
			</fieldset>
			<div class="actions">
				<?php echo form_submit($submit, 'Log in'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<div class="span4">
		<h3>Having problems?</h3>
		<ul class="events unstyled">
			<li><?php echo anchor('/auth/forgot_password/', 'Forgotten password?'); ?></li>
			<li><?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?></li>
		</ul>
	</div>
</div>
