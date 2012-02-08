			</div>
			<footer>
				<p>&copy; Project Rabbit 2012</p>
			</footer>
		</div>
		<script src="<?= base_url(); ?>/js/jquery.1.7.1.min.js"></script>
		<script src="<?= base_url(); ?>/js/bootstrap-tabs.js"></script></script>
		<script src="<?= base_url(); ?>/js/bootstrap-dropdown.js"></script></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.5&amp;sensor=false"></script>
		<script src="<?= base_url(); ?>/js/rabbit.js"></script></script>
		<?php if($this->uri->segment(1)=="explore"){ ?>
			<script>
				$(function() {
					RABBIT.map.init();
				});
			</script>
		<?php } ?>
		<?php if($this->uri->segment(1)=="api"){ ?>
		<script>
			$(function(){
				$('#api-links a').on('click',function(e){
					e.preventDefault();
					var url = this.href;
					$('#result').text('Loading...');
					$.getJSON(url, function(data) {
						$('#result').text(JSON.stringify(data));
					});
				});
			});
		</script>
		<?php } ?>
  </body>
</html>
