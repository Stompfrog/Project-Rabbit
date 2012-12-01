<div class="page-header">
	<h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span14">
		<h2>What's it all about?</h2>
		<h3>Collaborate with like-minded, local artists.</h3>
		<hr />
	</div>
</div>
<div class="row">
	<div class="span4">
		<p>Artists are anyone who are involved in creativity. From the smallest doodles to the grandest fine paintings. Get connected to your inner creativity, join up and get involved with people in your area. The steps are easy:</p>
	</div>
	<div class="span1">&nbsp;</div>
	<div class="span4">
		<ul>
		    <li>Register as an artist</li>
		    <li>Find others in your area</li>
		    <li>Become friends and organise a group</li>
		</ul>
	</div>
	<div class="span1">&nbsp;</div>
	<div class="span4">
		<ul>
		    <li>Start creating</li>
		    <li>Organise exhibitions, art days, get togethers, and show the world!</li>
		</ul>
	</div>
</div>
<hr />
<div class="row">
	<div class="span14">
		<div id="map"></div>
	</div>
</div>
<hr />
<div class="row">
	<div class="span10">
		<h2>It's all about art</h2>
		<h3>Artists images</h3>
		<hr />
		<div id="images_scroll">
			<?php
				if(isset($latest_images)) {
					echo '<ul class="media-grid">';
					foreach ($latest_images as $image) {
						echo '<li><a title="' . $image['title'] . '" href="' . site_url() . 'artists/' . $image['user_id'] . '/image/' . $image['id'] . '/"><img alt="' . $image['alt'] . '" src="' . base_url() . '/pb/img/tn/' . $image['file_name'] . '"></a></li>';
					}
					echo '</ul>';

				}
			?>
		</div>
	</div>
	<div class="span4">
		<h3>Newest Artists</h3>
		<ul class="artists unstyled">
			<?php foreach($latest as $row): ?>
			<li>
				<a href="<?php echo site_url(); ?>artists/<?php echo $row->user_id; ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php if(sizeof($latest_events) > 0) { ?>
		<h3>Upcoming Events</h3>
		<ul class="events unstyled">
			<?php foreach($popular_places as $row): ?>
		    <li><a href="#">Ealing, London</a> -  22/01/12</li>
		    <?php endforeach; ?>
		</ul>
		<?php }
		if(sizeof($popular_places) > 0) { ?>
		<h3>Popular Places</h3>
		<ul class="places unstyled">
			<?php foreach($popular_places as $row): ?>
		    <li>
				<a href="<?php echo site_url(); ?>places/<?php echo $row->id; ?>"><?php echo $row->address_1 . ', ' . $row->address_2 . ', ' . $row->city ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php }
		if(sizeof($latest_groups) > 0) { ?>
		<h3>Latest Groups</h3>
		<ul class="places unstyled">
			<?php foreach($latest_groups as $row): ?>
		    <li>
		    <?php
			    $format = "dS F, Y";
				$oDate = new DateTime($row->created_date);
				$sDate = $oDate->format($format);
			?>
				<a href="<?php echo site_url(); ?>groups/group/<?php echo $row->id; ?>"><?php echo $row->group_name; ?></a> (<?= $sDate ?>)
			</li>
			<?php endforeach; ?>
		</ul>
		<?php } ?>
	</div>


</div>