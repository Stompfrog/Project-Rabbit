<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">

		<?php if (isset($addresses)) {
		
			foreach ($addresses as $address) {
				echo '<div class="span5 address">';
				echo $address->get_vcard();
				
				?><ul class="events unstyled">
					<li><a href="<?= site_url() ?>addresses/edit_address/<?= $address->get_id() ?>" class="btn success">Edit address</a></li>
					<li><a href="<?= site_url() ?>addresses/delete_address/<?= $address->get_id() ?>" class="btn danger">Delete address</a></li>
				</ul><?php
				
				echo '</div>';
			}
			
		} else {
			echo 'there are no addresses';
		} ?>

	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>