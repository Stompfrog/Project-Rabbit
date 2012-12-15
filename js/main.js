require ([
	'jQuery', 
	'Underscore', 
	'Backbone',
	'Artify',
	'text!templates/infinite_images.html'], 
	function ($, _, Backbone, Artify, images_template) {

		/*
		$(function() {
			Artify.map.userInit();
		});
		
		$(function() {
		    Artify.map.userInit();
		});
		*/

		$(function(){
		
			if (document.getElementById('map')) {
				Artify.map.init();
			}
		
		    $('#api-links a').on('click',function(e) {
		        e.preventDefault();
		        var url = this.href;
		        $('#result').text('Loading...');
		        $.getJSON(url, function(data) {
		                $('#result').text(JSON.stringify(data));
		        });
		    });
		    		    
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

			$('#explore_interests').submit(function() {
				Artify.map.jsonUrl = this.action + '?' + $(this).serialize();
				Artify.map.getArtists();
				return false;
			});            
 
 			//infinite scroll on hopepage at the moment
 			if (document.getElementById('images_scroll')) {
 				//need a closure to keep a tab of page numbers
				var scroll_handler = (function () {
					var page = 1, per_page = 12;
					return function () {
						if($(window).scrollTop() + $(window).height() == $(document).height()) {
							page++;
							$.ajax({
							    type: "GET",
							    url: "/api/images/latest/" + page + "/" + per_page + "/",
							    success: function(result) {
									if(result == "false") {
										//if response is false, remove this function from window
										$(window).unbind("scroll");
									} else {
										$("#images_scroll ul").append(_.template(images_template, {images : JSON.parse(result) }));
									}
							    }
							});
						}
					}
				})();
				
				$(window).scroll(scroll_handler);		
 			}
		});
	}
);