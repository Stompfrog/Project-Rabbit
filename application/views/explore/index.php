<div class="page-header">
	<h1>Explore</h1>
</div>
<div class="row">
	<div class="span14">
		<h2>Explore your local area</h2>
		<hr />
	    <div id="map" style="width:100%;height:400px;"></div>
	</div>
	
	<div class="span14">
		<h2>Refine search</h2>
		<form method="get" action="<?= site_url() ?>api/artists/interests/" id="explore_interests">
			<style>
				label {
					display: inline;
					float: none;
					padding-left: 10px;
				}
			</style>
			<ul class="unstyled">
			<?php
				if(isset($interests)) {
					for ($i = 0; $i < sizeof($interests); $i++) { ?>
						<li><input type="checkbox" name="interests[]" value="<?= $interests[$i]['id'] ?>" id="interest<?= $interests[$i]['id'] ?>"><label for="interest<?= $interests[$i]['id'] ?>"><?= $interests[$i]['title'] ?></label></li>
					<?php }
				}
			?>
			</ul>
			<input type="submit" value="Submit">
		</form>	
	</div>
</div>