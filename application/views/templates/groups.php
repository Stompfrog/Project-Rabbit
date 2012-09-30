<?php

//print_r($groups);

if (isset($groups) && sizeof($groups) > 0) {
	echo '<h3>Groups</h3>';
	echo '<ul class="events unstyled">';
		for ($i = 0; $i < sizeof($groups); $i++) {
			echo '<li><a href="#">' . $groups[$i]->get_group_name() . '</a> - ' . $groups[$i]->get_created_date() . '</li>';
		}
	echo '</ul>';
} ?>
