<div class="page-header">
        <h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>API</h2>
		<hr />
		<h3>What are you after?</h3>
		<ul id="api-links">
		        <li>Get the 2 latest artists as JSON = <?php echo anchor('/api/artists/2', '/api/artists/2'); ?></li>
		        <li>Get the artist with id 2 as JSON = <?php echo anchor('/api/artist/2', '/api/artist/2'); ?></li>
		        <li>Get the all artists JSON = <?php echo anchor('/api/allartists', '/api/allartists'); ?></li>
		</ul>
		<ul id="api-links">
		        <li>Get number of artists JSON = <?php echo anchor('/api/gettotalartists', '/api/gettotalartists'); ?></li>
		</ul>
		<ul id="api-links">
		        <li>Get the all friends JSON = <?php echo anchor('/api/friends/1', '/api/friends/1'); ?></li>
		        <li>Get the all pending friends JSON = <?php echo anchor('/api/pendingfriends/1', '/api/pendingfriends/1'); ?></li>
		</ul>
		<ul id="api-links">     
		        <li>User 3 requesting user 1 to be friends = <?php echo anchor('/api/addfriend/3/1/', '/api/addfriend/3/1/'); ?></li>
		        <li>User 3 has already requested user 1 = <?php echo anchor('/api/already_requested/3/1/', '/api/already_requested/3/1/'); ?></li>
		        <li>User 1 confirming user 3 as a friend = <?php echo anchor('/api/confirmfriend/1/3/', '/api/confirmfriend/1/3/'); ?></li>
		        <li>User 1 removing user 3 as a friend = <?php echo anchor('/api/unfriend/1/3/', '/api/unfriend/1/3/'); ?></li>
		        <li>User 1 is friends with user 3 = <?php echo anchor('/api/already_friends/1/3/', '/api/already_friends/1/3/'); ?></li>
		</ul>
		<ul id="api-links">     
		        <li>Artists near location (miles, lat, lng) = <?php echo anchor('/api/get_addresses/9999/55.0/-1.56/', 'api/get_addresses/9999/55.0/-1.56/'); ?></li>
		</ul>
		
		
		
		<pre id="result">Results of API call will be loaded here...</pre>
	</div>
</div>