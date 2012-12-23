<div class="page-header">
        <h1>Welcome to Artify.co!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>API</h2>
		<hr />
		<h3>Artists</h3>
		<ul id="api-links">
			<li>All artists JSON = <?php echo anchor('/api/artists/', '/api/artists/'); ?></li>
			<li>Get number of artists JSON = <?php echo anchor('/api/artists/total/', '/api/artists/total/'); ?></li>
			<li>Get the 2 latest artists as JSON = <?php echo anchor('/api/artists/latest/2/', '/api/artists/latest/2/'); ?></li>
			<li>Get the artist with id 2 as JSON = <?php echo anchor('/api/artists/artist/2/', '/api/artists/artist/2/'); ?></li>
		</ul>
		<hr />
		<h3>Interests</h3>
		<ul id="api-links">
		    <li>Get the all artists with interests in Acrylics and Watercolour JSON = <?php echo anchor('/api/artists/interests/?interests[]=3&interests[]=4', '/api/artists/interests/?interests[]=3&interests[]=4'); ?></li>
		</ul>
		<hr />
		<h3>Images</h3>
		<ul id="api-links">
		    <li>Get the all images, page, how many per page = <?php echo anchor('/api/images/latest/1/4', '/api/images/latest/1/4'); ?></li>
		</ul>
		<hr />
		<h3>Friends</h3>
		<ul id="api-links">
			<li>Get the all current logged in users friends JSON = <?php echo anchor('/api/friends/', '/api/friends/'); ?></li>
			<li>Get the all your pending friends JSON = <?php echo anchor('/api/friends/pending/', '/api/friends/pending/'); ?></li>
		</ul>
		<hr />
		<ul id="api-links">     
			<li>Current user requesting user 1 to be friends = <?php echo anchor('/api/friends/add/1/', '/api/friends/add/1/'); ?></li>
			<li>Current user has already requested user 3 = <?php echo anchor('/api/friends/already_requested/3/', '/api/friends/already_requested/3/'); ?></li>
			<li>User 3 has invited current user = <?php echo anchor('/api/friends/has_invited/3/', '/api/friends/has_invited/3/'); ?></li>
			<li>Current user confirming user 3 as a friend = <?php echo anchor('/api/friends/confirm/3/', '/api/friends/confirm/3/'); ?></li>
			<li>Current user removing user 3 as a friend = <?php echo anchor('/api/friends/unfriend/3/', '/api/friends/unfriend/3/'); ?></li>
			<li>Current user is friends with user 3 = <?php echo anchor('/api/friends/already_friends/3/', '/api/friends/already_friends/3/'); ?></li>
		</ul>
		<hr />
		<h3>Location search</h3>
		<ul id="api-links">     
		    <li>Artists near location (miles, lat, lng) = <?php echo anchor('/api/addresses/near/20/55.0/-1.56/', 'api/addresses/near/20/55.0/-1.56/'); ?></li>
		</ul>
		<hr />
		<h3>Groups and group membership</h3>
		<ul id="api-links">
			<li>total groups = <?php echo anchor('/api/groups/total/', '/api/groups/total/'); ?></li>
			<li>get group 10 = <?php echo anchor('/api/groups/group/10/', '/api/groups/group/10/'); ?></li>
			<li>user requests to join group = <?php echo anchor('/api/groups/group/join/10/', '/api/groups/group/join/10/'); ?></li>
			<li>get all user requests to join group = <?php echo anchor('/api/groups/group/requests/10/', '/api/groups/group/requests/10/'); ?></li>
			<li>member invites another user to join group = <?php echo anchor('/api/groups/group/invite/10/2/', 'api/groups/group/invite/10/2/'); ?></li>
			<li>member leaves group = <?php echo anchor('/api/groups/group/leave/10/', 'api/groups/group/leave/10/'); ?></li>
			<li>invited user declines joining group = <?php echo anchor('/api/groups/group/decline/10/', 'api/groups/group/decline/10/'); ?></li>
			<li>user accepts group invitation = <?php echo anchor('/api/groups/group/accept/10/', '/api/groups/group/accept/10/'); ?></li>
			<li>administrator or above accept user into group = <?php echo anchor('/api/groups/group/accept/10/2/', '/api/groups/group/accept/10/2/'); ?></li>
			<li>administrator or above deny user entry into group = <?php echo anchor('/api/groups/group/deny/10/2/', '/api/groups/group/deny/10/2/'); ?></li>
			<li>administrator or above remove user from group = <?php echo anchor('/api/groups/group/remove/10/2/', '/api/groups/group/remove/10/2/'); ?></li>
			<li>creator reassigns user as group creator = <?php echo anchor('/api/groups/group/reassign/10/2/', '/api/groups/group/reassign/10/2/'); ?></li>
		</ul>
		<pre id="result">Results of API call will be loaded here...</pre>
	</div>
</div>