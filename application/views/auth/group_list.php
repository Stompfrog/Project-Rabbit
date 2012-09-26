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
		
			echo '<ul class="search-results">';
			
			foreach ($groups as $group) {

				echo '<li>';
					echo '<ul class="media-grid">';
						echo '<li><a href="<?php echo base_url(); ?>index.php/groups/render/' . $group->get_id() . '"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li>';
					echo '</ul>';
					echo '<h3><a href="' . base_url() . 'index.php/groups/render/' . $group->get_id() . '">' . $group->get_group_name() . '</a></h3>';
					echo '<p>' . $group->get_description() . '</p>';
					echo '<span class="label warning">test</span> <a class="pull-right" href="' . base_url() . 'index.php/groups/render/' . $group->get_id() . '">View group &raquo;</a>';
				echo '</li>';
		
			}
			
			echo '</ul>';
		
		} else
			echo 'you do not have any groups';
		?>
	
		</div>
	</div>
	<?php $this->load->view('auth/sidebar'); ?>
</div>