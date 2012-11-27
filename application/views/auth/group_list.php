<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">
	
		<?php
		if (isset($groups)) {
			echo '<ul class="search-results">';
			
			foreach ($groups as $group) {

				echo '<li>';
					echo '<ul class="media-grid">';
						echo '<li><a href="' . site_url() . 'groups/group/' . $group->get_id() . '"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li>';
					echo '</ul>';
					echo '<h3><a href="' . site_url() . 'groups/group/' . $group->get_id() . '">' . $group->get_group_name() . '</a></h3>';
					echo '<p>' . $group->get_description() . '</p>';
					if (($group->is_creator() !== null) && ($group->is_creator() == $this->tank_auth->get_user_id())) {
						echo '<a class="btn small danger" href="' . site_url() . 'groups/delete/' . $group->get_id() . '">Delete group</a>';
					}
					if (($group->is_admin() !== null) && ($group->is_admin() == $this->tank_auth->get_user_id())) {
						echo '<a class="btn small success" href="' . site_url() . 'groups/edit_group/' . $group->get_id() . '">Edit group</a>';
					}
					echo '<a class="pull-right" href="' . site_url() . 'groups/group/' . $group->get_id() . '">View group &raquo;</a>';
				echo '</li>';
			}
			echo '</ul>';
		} else {
			echo 'you do not have any groups';
		}
		?>	
	</div>
	<?php
		$data['logged_in_user'] = $logged_in_user;
		$data['user'] = $user;
		//sidebar
		$this->load->view('templates/sidebar', $data);
	?>
</div>