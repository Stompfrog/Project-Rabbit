<div class="page-header">
	<h1>Events</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>What are events?</h2>
		<hr />
		<p><b>Events are...</b> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
		<ul>
		   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		   <li>Aliquam tincidunt mauris eu risus.</li>
		   <li>Vestibulum auctor dapibus neque.</li>
		</ul>
		<a class="btn info" href="<?php echo base_url(); ?>index.php/auth/register">Create an event!</a>
	   <hr />
		<h2>Upcoming events</h2>
		<hr />
		<ul class="search-results">
			<li>
				<ul class="media-grid"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo base_url(); ?>index.php/events/render">Event title 1</a> - xx/xx/12</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label notice">Workshop</span> <a href="<?php echo base_url(); ?>index.php/events/render">More details</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo base_url(); ?>index.php/events/render">Event title 2</a> - xx/xx/12</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label notice">Gallery</span> <a href="<?php echo base_url(); ?>index.php/events/render">More details</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo base_url(); ?>index.php/events/render">Event title 3</a> - xx/xx/12</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label notice">Screening</span> <a href="<?php echo base_url(); ?>index.php/events/render">More details</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo base_url(); ?>index.php/events/render">Event title 4</a> - xx/xx/12</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label notice">Workshop</span> <a href="<?php echo base_url(); ?>index.php/events/render">More details</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo base_url(); ?>index.php/events/render">Event title 5</a> - xx/xx/12</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label notice">Gallery</span> <a href="<?php echo base_url(); ?>index.php/events/render">More details</a>
			</li>
		</ul>
		<div class="pagination">
			<ul>
				<li class="prev disabled"><a href="<?php echo base_url(); ?>index.php/events/render">&larr; Previous</a></li>
				<li class="active"><a href="<?php echo base_url(); ?>index.php/events/render">1</a></li>
				<li><a href="<?php echo base_url(); ?>index.php/events/render">2</a></li>
				<li><a href="<?php echo base_url(); ?>index.php/events/render">3</a></li>
				<li><a href="<?php echo base_url(); ?>index.php/events/render">4</a></li>
				<li><a href="<?php echo base_url(); ?>index.php/events/render">5</a></li>
				<li class="next"><a href="<?php echo base_url(); ?>index.php/events/render">Next &rarr;</a></li>
			</ul>
		</div>						
	</div>
	<div class="span4">
		<h3>Search events</h3>
		<input class="span3" type="text" placeholder="Search..." /> <a href="<?= base_url(); ?>index.php/search/" class="btn primary" />Go</a>
	
		<h3>Events Calendar</h3>
		<ul class="media-grid pull-left"><li><a href="<?php echo base_url(); ?>index.php/events/render"><img alt="" src="http://placehold.it/210x210" class="thumbnail"></a></li></ul>
	
		<h3>Popular Events</h3>
		<ul class="events unstyled">
			<li><a href="<?php echo base_url(); ?>index.php/events/render">Event 1</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/events/render">Event 2</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/events/render">Event 3</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/events/render">Event 4</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/events/render">Event 5</a></li>
		</ul>
	</div>
</div>