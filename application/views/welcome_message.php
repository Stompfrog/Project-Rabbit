<div class="page-header">
	<h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>What's it all about?</h2>
		<h3>Collaborate with like-minded, local artists.</h3>
		<hr />
		<div class="row">
			<div class="span10">
				<form class="form-stacked" action="">
				<fieldset>
					<legend>Find artists near you</legend>
						<div class="clearfix">
							<label for="postcode">Enter your address</label>
							<div class="input">
								<input type="text" size="30" name="address" id="address">
							</div>
							<div class="clearfix">
								<label>Lat</label>
								<div class="input">
									<input type="text" size="30" name="lat" id="lat">
								</div>
							</div>
							<div class="clearfix">
								<label>Lon</label>
								<div class="input">
								    <input type="text" size="30" name="lon" id="lon">
								</div>
							</div>
						</div>
					</fieldset>
					<div id="map"></div>
				</form>
			</div>
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
				<a href="<?php echo site_url(); ?>groups/<?php echo $row->id; ?>"><?php echo $row->group_name; ?></a> (<?= $sDate ?>)
			</li>
			<?php endforeach; ?>
		</ul>
		<?php } ?>
	</div>
</div>