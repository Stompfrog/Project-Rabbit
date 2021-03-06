<div class="page-header">
	<h1>Places</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>What are places?</h2>
		<hr />
		<p><b>Places are...</b> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
		<ul>
		   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
		   <li>Aliquam tincidunt mauris eu risus.</li>
		   <li>Vestibulum auctor dapibus neque.</li>
		</ul>
		<a class="btn success" href="<?php echo site_url(); ?>auth/register">Add a new place!</a>
       <hr />
		<h2>Latest Places</h2>
		<hr />
		<ul class="search-results">
			<li>
				<ul class="media-grid"><li><a href="<?php echo site_url(); ?>places/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo site_url(); ?>places/render">Place Name</a></h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label success">Shop</span> <a class="pull-right" href="<?php echo site_url(); ?>places/render">View profile &raquo;</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo site_url(); ?>places/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo site_url(); ?>places/render">Place Name</a></h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label success">Private residence</span> <a class="pull-right" href="<?php echo site_url(); ?>places/render">View profile &raquo;</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo site_url(); ?>places/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo site_url(); ?>places/render">Place Name</a></h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label success">Gallery</span> <a class="pull-right" href="<?php echo site_url(); ?>places/render">View profile &raquo;</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo site_url(); ?>places/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo site_url(); ?>places/render">Place Name</a></h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label success">Shop</span> <a class="pull-right" href="<?php echo site_url(); ?>places/render">View profile &raquo;</a>
			</li>
			<li>
				<ul class="media-grid"><li><a href="<?php echo site_url(); ?>places/render"><img alt="" src="http://placehold.it/60x60" class="thumbnail"></a></li></ul>
				<h3><a href="<?php echo site_url(); ?>places/render">Place Name</a></h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<span class="label success">Gallery</span> <a class="pull-right" href="<?php echo site_url(); ?>places/render">View profile &raquo;</a>
			</li>
		</ul>
		<div class="pagination">
			<ul>
				<li class="prev disabled"><a href="#">&larr; Previous</a></li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li class="next"><a href="#">Next &rarr;</a></li>
			</ul>
		</div>						
	</div>
	<div class="span4">
		<h3>Search places</h3>
		<input class="span3" type="text" placeholder="Search..." /> <a href="<?= site_url(); ?>search/" class="btn primary" />Go</a>
		<br /><br />
		<h3>Popular Places</h3>
		<ul class="events unstyled">
			<li><a href="<?php echo site_url(); ?>places/render">Place 1</a></li>
			<li><a href="<?php echo site_url(); ?>places/render">Place 2</a></li>
			<li><a href="<?php echo site_url(); ?>places/render">Place 3</a></li>
			<li><a href="<?php echo site_url(); ?>places/render">Place 4</a></li>
			<li><a href="<?php echo site_url(); ?>places/render">Place 5</a></li>
		</ul>
	</div>
</div>
