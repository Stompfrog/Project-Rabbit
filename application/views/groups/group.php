<div class="page-header">
	<h1>Welcome to Artify.co!</h1>
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
			$members = $group->get_group_members();
			for ($i = 0; $i < sizeof($members); $i++ ) {
				if ($members[$i]['rights'] <= 3) {
					echo '<li><a href="' . site_url() . 'artists/' . $members[$i]['user_id'] . '">' . $members[$i]['first_name'] . ' ' .$members[$i]['last_name'] . '</a>';
					if($members[$i]['rights'] == 1) {
						//if current user is owner, show edit and delete links
						if($members[$i]['user_id'] == $user_id) {
							echo ' | <a href="' . site_url() . 'groups/edit_group/' . $group->get_id() . '">Edit group</a>';
							echo ' | <a href="' . site_url() . 'groups/group/' . $group->get_id() . '">Delete group</a>';
						} else {
							//otherwise just state they are owners
							echo ' | Owner';
						}
					}
					if ($members[$i]['rights'] <= 2)
						echo ' | Administrator';
					echo '</li>';
				}
			}
			?>
		</ul>
	</div>
	<div class="span4">
	<p></p>
	<?php
		//<ul class="media-grid pull-left"><li><a href="#"><img alt="" src="http://placehold.it/210x210" class="thumbnail"></a></li></ul>
		//<a href="#">Upload/edit profile picture</a>
	?>
	</div>
</div>