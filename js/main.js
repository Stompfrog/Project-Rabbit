//this file should replace the main one
require ([
	'jQuery', 
	'Underscore', 
	'Backbone',
	'Artify'], 
	function ($, _, Backbone, Artify) {

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
		});
	}
);