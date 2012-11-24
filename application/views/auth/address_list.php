<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your addresses</h2>
		<hr />
		<div class="span10">
		
		
		<?php
		
		if (isset($addresses)) {
		
			foreach ($addresses as $address) {
				echo '<div class="span5 address">';
				echo $address->get_vcard();
				
				?><ul class="events unstyled">
					<li><a href="<?= site_url() ?>admin/addresses/edit_address/<?= $address->get_id() ?>" class="btn success">Edit address</a></li>
					<li><a href="<?= site_url() ?>admin/addresses/delete_address/<?= $address->get_id() ?>" class="btn danger">Delete address</a></li>
				</ul><?php
				
				echo '</div>';
			}
		
		} else
			echo 'there are no addresses';
		?>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>