<div class="page-header">
        <h1>Welcome to project rabbit!</h1>
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
				<a href="<?php echo base_url(); ?>index.php/artists/<?php echo $row->user_id; ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
			</li>
			<?php endforeach; ?>
		</ul> 
		<h3>Upcoming Events</h3>
		<ul class="events unstyled">
		    <li><a href="#">Ealing, London</a> -  22/01/12</li>
		    <li><a href="#">Reading</a> -  26/01/12</li>
		</ul>
		<h3>Popular Places</h3>
		<ul class="places unstyled">
		    <li><a href="#">Jelly Arts</a> - Reading</li>
		    <li><a href="#">Robson Rooms</a> - Southbank, London</li>
		</ul>
	</div>
</div>