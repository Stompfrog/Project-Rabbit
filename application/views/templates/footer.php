		        </div>
		        <footer>
		                <p>&copy; Artify.co 2012</p>
		        </footer>
		</div>
		<script src="<?= base_url(); ?>/js/jquery.1.7.1.min.js"></script>
		<script src="<?= base_url(); ?>/js/bootstrap-tabs.js"></script></script>
		<script src="<?= base_url(); ?>/js/bootstrap-dropdown.js"></script></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.5&amp;sensor=false"></script>
		<script type="text/javascript" src="<?= base_url(); ?>/js/jquery-ui-1.8.1.custom.min.js"></script>
		
		<script src="<?= base_url(); ?>/js/jsont.js"></script></script>
		<script src="<?= base_url(); ?>/js/rabbit.js"></script></script>
		<?php
		if (isset($loadmap) && $loadmap == TRUE) {
		?>
			<script>
				$(function() {
				    RABBIT.map.userInit();
				});
			</script>
		<?php }
		
		//footer should receive parameters for what js to be included, not do any conditional code
		if($this->uri->segment(1)==""){ ?>
				<script>
				    $(function() {
				    	RABBIT.map.init();
				    });
				</script>
		<?php } else if($this->uri->segment(1)=="explore" || $this->uri->segment(1)=="" || $this->uri->segment(2)=="edit_address"){ ?>
		        <script>
					$(function() {
					    RABBIT.map.userInit();
					});
		        </script>
		<?php } ?>
		<?php if($this->uri->segment(1)=="api"){ ?>
		<script>
			$(function(){
			    $('#api-links a').on('click',function(e) {
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
		<?php if($this->tank_auth->is_logged_in()) { ?>
		<script>
			$(function(){			    
			    $('a.friend').on('click', function (e) {
				    e.preventDefault();
				    var parentEl = $(this).parent();
					$.ajax({
					  url: this.href
					}).done(function( html ) {
					  $(this).remove();
					  $(parentEl).html(html);
					});
			    });
			});
		</script>
		<?php } ?>
	</body>
</html>