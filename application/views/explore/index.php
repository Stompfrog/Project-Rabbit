<div class="page-header">
	<h1>Explore</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>Explore your local area</h2>
		<hr />
		<ul class="tabs" data-tabs="tabs">
		    <li class="active"><a href="#artists">Artists</a></li>
		    <li><a href="#groups">Groups</a></li>
		    <li><a href="#places">Places</a></li>
		    <li><a href="#events">Events</a></li>
	    </ul>
	    <div class="tab-content">
			<div class="active" id="artists">
				<h3>Find local artists</h3>
<<<<<<< HEAD
				<ul class="media-grid"><li><a href="#"><img alt="" src="http://placehold.it/550x300" class="thumbnail"></a></li></ul>
=======
				<ul class="media-grid"><li><a href="#"><img alt="" src="http://placehold.it/550x350" class="thumbnail"></a></li></ul>
>>>>>>> 2b91b7a61b063b4df8998d6c8fd45c8aa3b56d0e
				<h4>Filter options</h4>
				<input type="checkbox"/> Oils&nbsp;&nbsp;&nbsp; <input type="checkbox"/> Acryllic&nbsp;&nbsp;&nbsp; <input type="checkbox"/> watercolour&nbsp;&nbsp;&nbsp; <input type="checkbox"/> mixed media
			</div>
			<div id="groups">
				<h3>Find local groups</h3>
				<ul class="media-grid"><li><a href="#"><img alt="" src="http://placehold.it/550x300" class="thumbnail"></a></li></ul>
			</div>
			<div id="places">
				<h3>Find local places</h3>
				<ul class="media-grid"><li><a href="#"><img alt="" src="http://placehold.it/550x300" class="thumbnail"></a></li></ul>
				<h4>Filter options</h4>
				<input type="checkbox"/> Galleries&nbsp;&nbsp;&nbsp; <input type="checkbox"/> Offices&nbsp;&nbsp;&nbsp; <input type="checkbox"/> Shops&nbsp;&nbsp;&nbsp; <input type="checkbox"/> private residences
			</div>
			<div id="events">
				<h3>Find local events</h3>
				<ul class="media-grid"><li><a href="#"><img alt="" src="http://placehold.it/550x300" class="thumbnail"></a></li></ul>
				<h4>Filter options</h4>
				<input type="checkbox"/> Exhibitions&nbsp;&nbsp;&nbsp; <input type="checkbox"/> Screenings&nbsp;&nbsp;&nbsp; <input type="checkbox"/> Workshops
			</div>
		</div>
	</div>
	<div class="span4">
		<h3>Explore stuff</h3>
		<p>Pick an marker from the map to see more information, or do a search.</p>
		<input class="span3" type="text" placeholder="Search..." /> <a href="<?= base_url(); ?>index.php/search/" class="btn primary" />Go</a>
		<hr />
		<h3>Mark Robson</h3>
		<dl>
			<dt>Location</dt>
			<dd>SE1</dd>
			<dt>Media</dt>
			<dd>oils, watercolour, mixed media</dd>
		</dl>
<<<<<<< HEAD
		<a href="#">View full profile &raquo;</a>
		<hr />
		<h3>Groups</h3>
		<ul class="events unstyled">
			<li><a href="#">Team Rocket</a></li>
			<li><a href="#">Naked Painters</a></li>
=======
		<a href="<?php echo base_url(); ?>index.php/artists/render">View full profile &raquo;</a>
		<hr />
		<h3>Groups</h3>
		<ul class="events unstyled">
			<li><a href="<?php echo base_url(); ?>index.php/groups/render">Team Rocket</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/groups/render">Naked Painters</a></li>
>>>>>>> 2b91b7a61b063b4df8998d6c8fd45c8aa3b56d0e
		</ul>
	</div>
</div>