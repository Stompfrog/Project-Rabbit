<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your addresses</h2>
		<hr />
		<div class="span10">
		
			<div class="span5 address">
				<div id="hcard-Mark-Robson" class="vcard">
					<a class="url fn" href="http://www.whiteforest.co.uk">Mark Robson</a>
					<div class="adr">
						<div class="street-address">23 QUEENS COURT</div>
						<span class="locality">NEWCASTLE UPON TYNE</span>, 
						<span class="postal-code">NE4 6BJ</span>
					</div>
				</div>
				<ul class="events unstyled">
					<li><a href="<?= base_url() ?>index.php/auth/edit_address/" class="btn success">Edit address</a></li>
					<li><a href="<?= base_url() ?>index.php/auth/delete_address/" class="btn danger">Delete address</a></li>
				</ul>
			</div>

			<div class="span5 address">
				<div id="hcard-Mark-Robson" class="vcard">
					<a class="url fn" href="http://www.whiteforest.co.uk">Mark Robson</a>
					<div class="adr">
						<div class="street-address">23 QUEENS COURT</div>
						<span class="locality">NEWCASTLE UPON TYNE</span>, 
						<span class="postal-code">NE4 6BJ</span>
					</div>
				</div>	
			</div>

	
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>