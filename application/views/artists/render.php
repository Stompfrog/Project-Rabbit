<div class="page-header">
	<h1>Welcome to project rabbit!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2><?= $user['first_name']; ?> <?= $user['last_name']; ?> <small>Member since April 10th 2001</small></h2>
		<hr />
		<h3>Wizard with a paint brush</h3>
		<p><?= $user['about_me']; ?></p>
		<dl>
			<dt>Country</dt>
			<dd><?= $user['country']; ?></dd>
			<dt>Website</dt>
			<dd><?= anchor($user['website'],$user['website']); ?></dd>
		</dl>
		<h4>Interests</h4>
		<ul>
			<li>Oils</li>
			<li>Watercolours</li>
		</ul>
		<h4>Portfolio</h4>
		<ul class="media-grid">
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
			<li><a href="#"><img alt="" src="http://placehold.it/110x110" class="thumbnail"></a></li>
		</ul>
	</div>
	<div class="span4">
		<ul class="media-grid pull-left"><li><a href="#"><img alt="" src="http://placehold.it/210x210" class="thumbnail"></a></li></ul>
		<a href="#">Upload/edit profile picture</a>
		<hr />
		<h3>Events attended</h3>
		<ul class="events unstyled">
			<li><a href="#">Ealing, London</a> -  22/01/12</li>
			<li><a href="#">Reading</a> -  26/01/12</li>
		</ul>
		<h3>Favourited Places</h3>
		<ul class="places unstyled">
			<li><a href="#">Jelly Arts</a> - Reading</li>
			<li><a href="#">Robson Rooms</a> - Southbank, London</li>
		</ul>
		<h3>Friends</h3>
		<ul class="events unstyled">
			<li><a href="#">Mark Robson</a></li>
			<li><a href="#">Chris Bewick</a></li>
		</ul>
	</div>
</div>
