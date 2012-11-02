<?php
if ($groups) {
	echo '<h3>Groups</h3>';
	echo '<ul class="events unstyled">';
	for ($i = 0; $i < sizeof($groups); $i++) {
		echo '<li><a href="' . base_url() . 'index.php/groups/render/' . $groups[$i]->get_id() .'">' . $groups[$i]->get_group_name() . '</a> - ' . $groups[$i]->get_created_date() . '</li>';
	}
	echo '</ul>';
} ?>