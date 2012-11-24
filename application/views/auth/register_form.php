<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$register = array(
	'name' => 'register',
	'id' => 'register',
	'class' => 'btn primary'
);
?>

<div class="page-header">
	<h1>Register</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Register</h2>
		<hr />
		<?php echo form_open($this->uri->uri_string()); ?>
	        <fieldset>
				<div class="clearfix">
					<?php echo form_label('Username', $username['id']); ?>
					<div class="input">
						<?php echo form_input($username); ?>
						<?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
					</div>
				</div>
				<div class="clearfix">
					<?php echo form_label('Email Address', $email['id']); ?>
					<div class="input">
						<?php echo form_input($email); ?>
						<?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
					</div>
				</div>
				<div class="clearfix">
					<?php echo form_label('Password', $password['id']); ?>
					<div class="input">
						<?php echo form_password($password); ?>
						<?php echo form_error($password['name']); ?>
					</div>
				</div>
				<div class="clearfix">
					<?php echo form_label('Confirm Password', $confirm_password['id']); ?>
					<div class="input">
						<?php echo form_password($confirm_password); ?>
						<?php echo form_error($confirm_password['name']); ?>
					</div>
				</div>
				<div class="clearfix">
				<?php if ($captcha_registration) { ?>
					<?php if ($use_recaptcha) { ?>
						<div id="recaptcha_image"></div>
						<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
						<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
						<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>


						<div class="clearfix">
							<label class="recaptcha_only_if_image" for="recaptcha_response_field">Enter the words above</label>
							<label class="recaptcha_only_if_audio" for="recaptcha_response_field">Enter the numbers you hear</label>
							<div class="input">
								<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />	
								<?php echo form_error('recaptcha_response_field'); ?>
							</div>
						</div>					
						<?php echo $recaptcha_html; ?>
					<?php } else { ?>
						<div class="clearfix">
							<div class="input">
								<p>Enter the code exactly as it appears:</p>
								<?php echo $captcha_html; ?>
							</div>
						</div>
						<div class="clearfix">
							<?php echo form_label('Confirmation Code', $captcha['id']); ?>
							<div class="input">
								<?php echo form_input($captcha); ?>
								<?php echo form_error($captcha['name']); ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</fieldset>
			<div class="actions">
				<?php echo form_submit($register, 'Register'); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<div class="span4">
		<h3>Already a member?</h3>
		<ul class="events unstyled">
			<li><a href="<?php echo site_url(); ?>auth/login" type="submit">Log in</a></li>
			<li><?php echo anchor('/auth/forgot_password/', 'Forgotten password?'); ?></li>
		</ul>
	</div>
</div>


<?php
/*
if ($use_username) {
        $username = array(
                'name'  => 'username',
                'id'    => 'username',
                'value' => set_value('username'),
                'maxlength'     => $this->config->item('username_max_length', 'tank_auth'),
                'size'  => 30,
        );
}
$email = array(
        'name'  => 'email',
        'id'    => 'email',
        'value' => set_value('email'),
        'maxlength'     => 80,
        'size'  => 30,
);
$lat = array(
        'name'  => 'lat',
        'id'    => 'lat',
        'value' => set_value('lat'),
        'maxlength'     => 40,
        'size'  => 30,
);
$lng = array(
        'name'  => 'lng',
        'id'    => 'lng',
        'value' => set_value('lng'),
        'maxlength'     => 40,
        'size'  => 30,
);
$password = array(
        'name'  => 'password',
        'id'    => 'password',
        'value' => set_value('password'),
        'maxlength'     => $this->config->item('password_max_length', 'tank_auth'),
        'size'  => 30,
);
$confirm_password = array(
        'name'  => 'confirm_password',
        'id'    => 'confirm_password',
        'value' => set_value('confirm_password'),
        'maxlength'     => $this->config->item('password_max_length', 'tank_auth'),
        'size'  => 30,
);
$captcha = array(
        'name'  => 'captcha',
        'id'    => 'captcha',
        'maxlength'     => 8,
);
$register = array(
        'name' => 'register',
        'id' => 'register',
        'class' => 'btn primary'
);
?>
<div class="page-header">
        <h1>Register now</h1>
</div>
<div class="row">
        <div class="span10">
                <h2>Register</h2>
                <hr />
                <?php echo form_open($this->uri->uri_string()); ?>
                <fieldset>
                                <div class="clearfix">
                                        <?php echo form_label('Username', $username['id']); ?>
                                        <div class="input">
                                                <?php echo form_input($username); ?>
                                                <?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
                                        </div>
                                </div>
                                <div class="clearfix">
                                        <?php echo form_label('Email Address', $email['id']); ?>
                                        <div class="input">
                                                <?php echo form_input($email); ?>
                                                <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
                                        </div>
                                </div>
                                <div id="map" style="width:500px; height:300px"></div>
                                <div class="clearfix">
                                        <div class="input">
                                                <?php echo form_label('Latitude', $lat['id']); ?>
                                                <div class="input">
                                                        <?php echo form_input($lat); ?>
                                                </div>
                                                <?php echo form_label('Longitude', $lng['id']); ?>
                                                <div class="input">
                                                        <?php echo form_input($lng); ?>
                                                </div>
                                                <label>Address: </label><input id="address"  type="text"/>
                                        </div>
                                </div>
                                <div class="clearfix">
                                        <?php echo form_label('Password', $password['id']); ?>
                                        <div class="input">
                                                <?php echo form_password($password); ?>
                                                <?php echo form_error($password['name']); ?>
                                        </div>
                                </div>
                                <div class="clearfix">
                                        <?php echo form_label('Confirm Password', $confirm_password['id']); ?>
                                        <div class="input">
                                                <?php echo form_password($confirm_password); ?>
                                                <?php echo form_error($confirm_password['name']); ?>
                                        </div>
                                </div>
                                <div class="clearfix">
                                <?php if ($captcha_registration) { ?>
                                        <?php if ($use_recaptcha) { ?>
                                                <div id="recaptcha_image"></div>
                                                <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                                <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                                                <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>


                                                <div class="clearfix">
                                                        <label class="recaptcha_only_if_image" for="recaptcha_response_field">Enter the words above</label>
                                                        <label class="recaptcha_only_if_audio" for="recaptcha_response_field">Enter the numbers you hear</label>
                                                        <div class="input">
                                                                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />     
                                                                <?php echo form_error('recaptcha_response_field'); ?>
                                                        </div>
                                                </div>                                  
                                                <?php echo $recaptcha_html; ?>
                                        <?php } else { ?>
                                                <div class="clearfix">
                                                        <div class="input">
                                                                <p>Enter the code exactly as it appears:</p>
                                                                <?php echo $captcha_html; ?>
                                                        </div>
                                                </div>
                                                <div class="clearfix">
                                                        <?php echo form_label('Confirmation Code', $captcha['id']); ?>
                                                        <div class="input">
                                                                <?php echo form_input($captcha); ?>
                                                                <?php echo form_error($captcha['name']); ?>
                                                        </div>
                                                </div>
                                        <?php } ?>
                                <?php } ?>
                        </fieldset>
                        <div class="actions">
                                <?php echo form_submit($register, 'Register'); ?>
                        </div>
                <?php echo form_close(); ?>
        </div>
        <div class="span4">
                <h3>Already a member?</h3>
                <ul class="events unstyled">
                        <li><a href="<?php echo site_url(); ?>auth/login" type="submit">Log in</a></li>
                        <li><?php echo anchor('/auth/forgot_password/', 'Forgotten password?'); ?></li>
                </ul>
        </div>
</div>
*/
?>