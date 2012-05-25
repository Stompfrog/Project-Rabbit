<div class="page-header">
	<h1>Artify.co</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Galleries</h2>
		<hr />
		<div class="span10">
			<?php if (isset($galleries)) { ?>
			<ul class="media-grid">
				<?php
				
				//
				foreach ($galleries as $gallery)
					echo '<li><a href="' . $gallery->get_admin_url() . '"><img alt="" src="' . $gallery->get_thumb() . '" class="thumbnail"></a></li>';
				?>
			</ul>
			<?php } else {
				echo '<p>No galleries</p>';
			} ?>
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>