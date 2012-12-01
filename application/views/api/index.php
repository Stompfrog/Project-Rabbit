<div class="page-header">
        <h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>API</h2>
		<hr />
		<h3>Artists</h3>
		<ul id="api-links">
			<li>Get the 2 latest artists as JSON = <?php echo anchor('/api/artists/2', '/api/artists/2'); ?></li>
			<li>Get the artist with id 2 as JSON = <?php echo anchor('/api/artist/2', '/api/artist/2'); ?></li>
		    <li>Get the all artists JSON = <?php echo anchor('/api/allartists', '/api/allartists'); ?></li>
		    <li>Get number of artists JSON = <?php echo anchor('/api/gettotalartists', '/api/gettotalartists'); ?></li>
		</ul>
		<hr />
		<h3>Interests</h3>
		<ul id="api-links">
		    <li>Get the all artists with interests in Acrylics and Watercolour JSON = <?php echo anchor('/api/all_artists_interests/?interests[]=3&interests[]=4', '/api/all_artists_interests/?interests[]=3&interests[]=4'); ?></li>
		</ul>
		<hr />
		<h3>Images</h3>
		<ul id="api-links">
		    <li>Get the all images, page, how many per page = <?php echo anchor('/api/images/1/4', '/api/images/1/4'); ?></li>
		</ul>
		<hr />
		<h3>Friends</h3>
		<ul id="api-links">
			<li>Get the all friends JSON = <?php echo anchor('/api/friends/1', '/api/friends/1'); ?></li>
			<li>Get the all pending friends JSON = <?php echo anchor('/api/pendingfriends/1', '/api/pendingfriends/1'); ?></li>
		</ul>
		<hr />
		<ul id="api-links">     
			<li>User 3 requesting user 1 to be friends = <?php echo anchor('/api/addfriend/3/1/', '/api/addfriend/3/1/'); ?></li>
			<li>User 3 has already requested user 1 = <?php echo anchor('/api/already_requested/3/1/', '/api/already_requested/3/1/'); ?></li>
			<li>User 1 confirming user 3 as a friend = <?php echo anchor('/api/confirmfriend/1/3/', '/api/confirmfriend/1/3/'); ?></li>
			<li>User 1 removing user 3 as a friend = <?php echo anchor('/api/unfriend/1/3/', '/api/unfriend/1/3/'); ?></li>
			<li>User 1 is friends with user 3 = <?php echo anchor('/api/already_friends/1/3/', '/api/already_friends/1/3/'); ?></li>
		</ul>
		<hr />
		<h3>Location search</h3>
		<ul id="api-links">     
		    <li>Artists near location (miles, lat, lng) = <?php echo anchor('/api/get_addresses/9999/55.0/-1.56/', 'api/get_addresses/9999/55.0/-1.56/'); ?></li>
		</ul>
		<hr />
		<h3>Groups and group membership</h3>
		<ul id="api-links">
			<li>user requests to join group = <?php echo anchor('/api/group/10/join/', '/api/group/10/join/'); ?></li>
			<li>member invites another user to join group = <?php echo anchor('/api/group/10/invite/2/', 'api/group/10/invite/2/'); ?></li>
			<li>get user's requests to join group = <?php echo anchor('/api/group/10/requests/', '/api/group/10/requests/'); ?></li>
			<li>accept user into group = <?php echo anchor('/api/group/10/accept/2/', '/api/group/10/accept/2/'); ?></li>
			<li>deny user entry into group = <?php echo anchor('/api/get_addresses/9999/55.0/-1.56/', 'api/get_addresses/9999/55.0/-1.56/'); ?></li>
			<li>remove user from group = <?php echo anchor('/api/group/10/remove/2/', '/api/group/10/remove/2/'); ?></li>
		</ul>
		<pre id="result">Results of API call will be loaded here...</pre>
	</div>
</div>