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
			$pending_members = array();
			
			for ($i = 0, $j = sizeof($members); $i < $j; $i++ ) {
			
				//user is in current group, whatever capacity
				if ($members[$i]['user_id'] == $user_id) {
					$is_member = $members[$i]['rights'];
				}
			
				if ($members[$i]['rights'] <= 3) {
					echo '<li><a href="' . site_url() . 'artists/' . $members[$i]['user_id'] . '">' . $members[$i]['first_name'] . ' ' . $members[$i]['last_name'] . '</a>';
					if($members[$i]['rights'] == 1) {
						if($members[$i]['user_id'] == $user_id) {
							$is_member = true;
							echo ' | <a href="' . site_url() . 'groups/edit_group/' . $group->get_id() . '">Edit group</a>';
							echo ' | <a href="' . site_url() . 'groups/delete_group/' . $group->get_id() . '">Delete group</a>';
						} else {
							echo ' | Owner';
						}
					}
					if ($members[$i]['rights'] == 2) {
						echo ' | Administrator';
					}
					//if current user, and is not admin
					if ($members[$i]['user_id'] == $user_id && $members[$i]['rights'] > 2) {
						$is_member = true;
						echo ' | <span><a href="' . site_url() . 'api/groups/group/leave/' . $group->get_id() . '" class="group">Leave group</a></span>';
					} else {
						echo ' | Member';
					}
					echo '</li>';
				} else {
					//put requested, blocked, invited members in array
					array_push($pending_members, $members[$i]);
				}
			}
			
			?>
		</ul>

		<?php
			//if current user is admin or above
			if ($is_member && $is_member <= 2 && sizeof($pending_members) > 0) {
				echo '<h4>Membership pending</h4>';
				echo '<ul>';
				for ($i = 0, $j = sizeof($pending_members); $i < $j; $i++ ) {
					//if user not listed above
					if ($pending_members[$i]['rights'] >= 4) {
						echo '<li><a href="' . site_url() . 'artists/' . $pending_members[$i]['user_id'] . '">' . $pending_members[$i]['first_name'] . ' ' . $pending_members[$i]['last_name'] . '</a>';
						//if user has requested
						if($pending_members[$i]['rights'] == 4) {
							echo ' | Reqested | <span><a href="' . site_url() . 'api/groups/group/accept/' . $group->get_id() . '/' . $pending_members[$i]['user_id'] . '" class="group btn success">Accept user</a><span>';
							echo ' | <span><a href="' . site_url() . 'api/groups/group/deny/' . $group->get_id() . '/' . $pending_members[$i]['user_id'] . '" class="group btn danger">Deny user</a><span>';
						}
						//user is invited, but hasn't accepted or declined yet
						if ($pending_members[$i]['rights'] == 5) {
							echo ' | User has been invited, but has not accepted yet';
						}
						//user is blocked, but give option to unblock
						if ($pending_members[$i]['rights'] == 5) {
							echo ' | <span><a href="' . site_url() . 'api/groups/group/accept/' . $group->get_id() . '/' . $pending_members[$i]['user_id'] . '" class="group">Unblock user</a></span>';
						}
						echo '</li>';
					}
				}
				echo '</ul>';
			}

			//if current logged in user is not a member of the group
			if($this->tank_auth->is_logged_in() && $group->get_user_id() != $user->get_id()) {
				switch ($is_member) {
				    case false:
				        echo '<p><a href="' . site_url() . 'api/groups/group/join/' . $group->get_id() . '" class="group btn success">Join Group</a></p>';
				        break;
				    case 4:
				        echo "Your request is pending";
				        break;
				    case 5:
				        echo 'You have been invited. <a href="' . site_url() . 'api/groups/group/accept/' . $group->get_id() . '" class="group btn success">Accept invitation</a>';
				        break;
				}
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