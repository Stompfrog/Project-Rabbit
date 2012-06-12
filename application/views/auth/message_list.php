<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Your Messages</h2>
		<hr />
		<div class="span10">

		<?php
		
		if (isset($messages)) {

			foreach ($messages as $message) {
				echo '<div class="span5 message">';
				echo $message;
				echo '</div>';
			}
		
		} else
			echo 'there are no messages';
		?>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>