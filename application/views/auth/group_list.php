<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your groups</h2>
		<hr />
		<div class="span10">
		<?php
		
		if (isset($groups)) {
		
			foreach ($groups as $group) {
				echo '<div class="span5 address">';
				//echo $group->get_vcard();
				
				/*?><ul class="events unstyled">
					<li><a href="<?= base_url() ?>index.php/admin/groups/edit_group/<?= $address->get_id() ?>" class="btn success">Edit address</a></li>
					<li><a href="<?= base_url() ?>index.php/admin/addresses/close_group/<?= $address->get_id() ?>" class="btn danger">Delete address</a></li>
				</ul><?php
				*/
				
				echo '</div>';
			}
		
		} else
			echo 'you do not have any groups';
		?>
	
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>