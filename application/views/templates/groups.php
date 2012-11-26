<?php
if ($groups) {
	echo '<ul class="events unstyled">';
	for ($i = 0; $i < sizeof($groups); $i++) {
		echo '<li><a href="' . site_url() . 'groups/render/' . $groups[$i]->get_id() .'">' . $groups[$i]->get_group_name() . '</a> - ' . $groups[$i]->get_created_date() . '</li>';
	}
	echo '</ul>';
} ?>