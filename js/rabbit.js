var RABBIT = RABBIT || {};

RABBIT.map = {
	//should be one off initialising for this first bit
	mapObj: undefined,
	infowindow: undefined,
	markersArray: [],
	jsonUrl: 'http://project-rabbit/index.php/api/allartists',
	currentAjaxRequest: undefined,
	currentOverlay: undefined,
	filter: {
        artist: {
            clusterImage: [{
                url: '/img/map_icons/artist_30x31.png',
                height: 31,
                width: 30,
                anchor: [5],
                textColor: '#002776',
                textSize: 12
            }, {
                url: '/img/artist_32x35.png',
                height: 35,
                width: 32,
                anchor: [7],
                textColor: '#002776',
                textSize: 12
            }, {
                url: '/img/map_icons/artist_45x45.png',
                height: 45,
                width: 45,
                anchor: [11],
                textColor: '#002776',
                textSize: 12
            }],
            markerImageURL: "/img/map_icons/artist.png",
            markerImageWidth: 40,
            markerImageHeight: 38,
            markerAnchorX: 20,
            markerAnchorY: 47,
            clusterMaxZoom: 11,
            clusterGridSize: 80,
            /**
            * jsonT template for processing info window data into HTML
              
				user_id
				website
				first_name
				last_name
				avatar_filename
				status
				sex
				about_me
				
            */
            jsontTemplate: {
                "self": "{container}",
                "container": "<h2>{$.first_name} {$.last_name}</h2><p>{$.about_me}{$.website}</p>",
                "container.status": "<h3>{$.status}</h2>",
                "container.about_me": function (about_me) {
                    return about_me ? "<p>" + about_me + "</p>" : "";
                },
                "container.website": function (website) {
                    return website ? '<p><a href="' + website + '">' + website + '</a></p>' : '';
                }
            }
        }
	},

	mapOptions: {
	  zoom: 6,
	  center: new google.maps.LatLng(53, -3.0),
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	},

	init: function () {

		//if available, set geoLocation, otherwise defaults will display
		this.getGeoLocation();
		//draw the map
		this.mapObj = new google.maps.Map(document.getElementById('map'), this.mapOptions);
		this.getArtists();
		this.attachEvents();
	},
	
	getGeoLocation: function () {
		//if geoLocation is, set default location
		var self = this, infowindow = undefined;
		
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				self.mapOptions.zoom = 12;
			    self.mapOptions.center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			    //display default message - although, if they are members we could welcome them back?
			    infowindow = new google.maps.InfoWindow({
			      map: self.mapObj,
			      position: self.mapOptions.center,
			      content: "Let's find artists near you!"
			    });
				self.currentOverlay = infowindow;
			});
			return true;
		}
		return false;
	},
	
	getArtists: function () {
	
		var self = this;
        // do Ajax to put in cache
        this.currentAjaxRequest = $.ajax({
			url: this.jsonUrl,
			dataType: "json",
            //data: $.param(requestQS),
            success: function (jsonData) {
                for (var i in jsonData) {
                	var latlng = new google.maps.LatLng(jsonData[i].lat, jsonData[i].lon);
					var marker = new google.maps.Marker({
					  position: latlng,
					  icon: self.filter['artist'].markerImageURL,
					  map: self.mapObj,
					  title: jsonData[i].first_name + ' ' + jsonData[i].last_name
					});

					(function (mymarker, mylatlng) {

						var infowindow = new google.maps.InfoWindow({
							content: jsonT({container: jsonData[i]}, RABBIT.map.filter.artist.jsontTemplate),
							position: mylatlng
						});
						
						google.maps.event.addListener(marker, 'click', function() {
							self.clearOverlays();
							infowindow.open(self.mapObj,mymarker);
							self.mapObj.panTo(mylatlng);
							self.currentOverlay	= infowindow;
						});		
					
					} )(marker, latlng);
					
					self.markersArray.push(marker);		

				}
            }
        });
	},
	
	attachEvents: function () {
		var self = this;
        // click Google Maps event for map canvas to clear all overlays
        google.maps.event.addListener(this.mapObj, 'click', function () {
			self.clearOverlays();
        });
	},
	
	//only one overlay should be displayed
	clearOverlays: function () {
		var self = this;
		if (self.currentOverlay.setMap) {
		    self.currentOverlay.setMap(null);
		}
	},
	
	clearMarkers: function () {
		if (this.markersArray) {
			for (var i = 0; i < this.markersArray.length; i++ ) {
				this.markersArray[i].setMap(null);
			}
		}
	}

};

/*
	Cookie kitchen
*/
RABBIT.kitchen = {

	createCookie: function (name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	},
	
	readCookie: function (name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},
	
	eraseCookie: function (name) {
		this.createCookie(name,"",-1);
	}
	
};
