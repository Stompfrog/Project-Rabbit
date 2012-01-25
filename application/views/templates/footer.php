			</div>
			<footer>
				<p>&copy; Project Rabbit 2012</p>
			</footer>
		</div>
		<script src="<?= base_url(); ?>/js/jquery.1.7.1.min.js"></script>
		<script src="<?= base_url(); ?>/js/bootstrap-tabs.js"></script></script>
		<script src="<?= base_url(); ?>/js/bootstrap-dropdown.js"></script></script>
		<script src="<?= base_url(); ?>/js/rabbit.js"></script></script>
		<?php if($this->uri->segment(1)=="explore"){ ?>
			<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
			<script src="<?= base_url(); ?>/js/explore.js"></script></script>
		<?php } ?>
		
  </body>
</html>
