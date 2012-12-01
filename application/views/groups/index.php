<?php
$logged_in_user = false;
if (isset($user)) {
	$logged_in_user = $this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $user->get_id();
}
?>
<div class="page-header">
	<h1>Groups</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>What are groups?</h2>
		<hr />
		<p>Groups are ways for you to meet like minded people and get some activity going. Start or join painting groups, photography groups, or get together with local people and just get creative!</p>
		<ul>
		   <li>Start a group.</li>
		   <li>Invite or accept invitations.</li>
		   <li>Start working together and start group events.</li>
		</ul>
		<?php 
			if ($this->tank_auth->is_logged_in()) {
				echo '<a class="btn warning" href="' . site_url() . 'groups/create/">Create a new group!</a>';
			} else {
				echo '<a class="btn warning" href="' . site_url() . 'auth/register">Register and create a new group!</a>';
			}
		?>
		<hr />
		<h2>Latest Groups</h2>
		<hr />
		<?php
		if (isset($groups)) {
			echo '<ul class="search-results">';
			for ($i = 0; $i < sizeof($groups); $i++) {
				echo '<li>';
					echo '<ul class="media-grid">';
						echo '<li><a href="<?php echo site_url(); ?>groups/group/' . $groups[$i]['id'] . '"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li>';
					echo '</ul>';
					echo '<h3><a href="' . site_url() . 'groups/group/' . $groups[$i]['id'] . '">' . $groups[$i]['group_name'] . '</a></h3>';
					echo '<p>' . $groups[$i]['description'] . '</p>';
					echo '<a class="pull-right" href="' . site_url() . 'groups/' . $groups[$i]['id'] . '">View group &raquo;</a>';
				echo '</li>';
			}
			echo '</ul>';
		} else {
			echo 'No groups yet, I know, that is terrible!';
		}
		?>
		<?php if (isset($pagination)) echo $pagination; ?>
	</div>
	<?php
		if ($this->tank_auth->is_logged_in()) {
			$data['logged_in_user'] = $logged_in_user;
			$data['user'] = $user;
			//sidebar
			$this->load->view('templates/sidebar', $data);
		} else { ?>
	<div class="span4"><?php
		//<h3>Search groups</h3>
		//<input class="span3" type="text" placeholder="Search..." /> <a href="<?= site_url(); ? >search/" class="btn primary" />Go</a>
	?></div>
		<?php } ?>
</div>