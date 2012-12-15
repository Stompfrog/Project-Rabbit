<?php 
$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
?>
<div class="page-header">
	<a href="<?= site_url() ?>artists/<?= $user->get_id() ?>"><h1><?= $user->get_name(); ?> <small>Member since <?= $user->get_member_since(); ?> </small></h1></a>
</div>
<div class="row">
	<div class="span10">

		<h2><?= $group->get_group_name() ?> <small><date><?= $group->get_created_date() ?></date></small></h2>
		<hr />
		<p><?= $group->get_description() ?></p>
		<h4>Members</h4>
		<ul>
		<?php
			$user_id = $this->tank_auth->get_user_id();
			$is_member = false;
			$members = $group->get_group_members();
			for ($i = 0; $i < sizeof($members); $i++ ) {
				echo '<li><a href="' . site_url() . 'artists/' . $members[$i]['user_id'] . '">' . $members[$i]['first_name'] . ' ' . $members[$i]['last_name'] . '</a>';
				if($members[$i]['is_creator'] == 1) {
					$is_member = true;
					if($members[$i]['user_id'] == $user_id) {
						echo ' | <a href="' . site_url() . 'groups/edit_group/' . $group->get_id() . '">Edit group</a>';
						echo ' | <a href="' . site_url() . 'groups/delete_group/' . $group->get_id() . '">Delete group</a>';
					} else {
						echo ' | Owner';
					}
				}
				if ($members[$i]['is_admin'] == 1) {
					echo ' | Administrator';
				}
				if ($members[$i]['user_id'] == $user_id && $members[$i]['is_creator'] != 1) {
					$is_member = true;
					echo ' | <a href="' . site_url() . 'api/groups/group/leave/' . $group->get_id() . '" class="group">Leave group</a>';
				} else {
					echo ' | Member';
				}
				echo '</li>';
			}
			?>
		</ul>
		
		<?php
			//if current user is not a member of the group
			if ($logged_in_user && !$is_member) {
				echo '<a href="">Join Group</a>';
				//if user is a member, show leave group button
				//if not a member already, show join group button
				//if administrator, 
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