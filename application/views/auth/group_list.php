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
						echo '<li><a href="<?php echo base_url(); ?>index.php/admin/groups/render/' . $group->get_id() . '"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li>';
					echo '</ul>';
					echo '<h3><a href="' . base_url() . 'index.php/admin/groups/render/' . $group->get_id() . '">' . $group->get_group_name() . '</a></h3>';
					echo '<p>' . $group->get_description() . '</p>';
					if (($group->is_creator() !== null) && ($group->is_creator() == $this->tank_auth->get_user_id())) {
						echo '<a class="btn small danger" href="' . base_url() . 'index.php/admin/groups/delete/' . $group->get_id() . '">Delete group</a>';
					}
					if (($group->is_admin() !== null) && ($group->is_admin() == $this->tank_auth->get_user_id())) {
						echo '<a class="btn small success" href="' . base_url() . 'index.php/admin/groups/edit_group/' . $group->get_id() . '">Edit group</a>';
					}
					echo '<a class="pull-right" href="' . base_url() . 'index.php/admin/groups/render/' . $group->get_id() . '">View group &raquo;</a>';
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