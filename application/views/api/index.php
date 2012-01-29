<div class="page-header">
	<h1>Welcome to project rabbit!</h1>
</div>
<div class="row">
	<div class="span10">
		<h2>API</h2>
		<hr />
		<h3>What are you after?</h3>
		<ul id="api-links">
			<li>Get the 2 latest artists as JSON = <?php echo anchor('/api/artists/2', '/api/artists/2'); ?></li>
			<li>Get the artist with id 2 as JSON = <?php echo anchor('/api/artist/2', '/api/artist/2'); ?></li>
		</ul>
		<pre><code id="result">Results of API call will be loaded here...</code></pre>
	</div>
</div>
