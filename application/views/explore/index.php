<div class="page-header">
	<h1>Explore</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Explore your local area</h2>
		<hr />
	    <div id="map" style="width:550px;height:350px;"></div>
	</div>
	<div class="span4">
		<h3>Explore stuff</h3>
		<p>Pick an marker from the map to see more information, or do a search.</p>
		<input class="span3" type="text" placeholder="Search..." /> <a href="<?= base_url(); ?>index.php/search/" class="btn primary" />Go</a>
		<hr />
		<h3>Show on map</h3>
		<ul class="events unstyled">
			<li>
				<input type="checkbox"> &nbsp;&nbsp;Artists
				<ul class="unstyled">
					<li><input type="checkbox"> &nbsp;&nbsp;Oils</li>
					<li><input type="checkbox"> &nbsp;&nbsp;Watercolours</li>
					<li><input type="checkbox"> &nbsp;&nbsp;Acrylics</li>
				</ul>
			</li>
			<li><input type="checkbox"> &nbsp;&nbsp;Groups</li>
			<li><input type="checkbox"> &nbsp;&nbsp;Places</li>
			<li><input type="checkbox"> &nbsp;&nbsp;Events</li>
		</ul>
	</div>
</div>