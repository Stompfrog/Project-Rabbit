var RABBIT = RABBIT || {};

RABBIT.map = {
	
	mapObj: undefined,
	infowindow: undefined,
	jsonUrl: 'http://project-rabbit/index.php/api/allartists',
	currentAjaxRequest: undefined,
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
            */
            jsontTemplate: {
                "self": "{container}",
                "container": "<h2>{$.Name}</h2>{$.Address1}{$.Address2}{$.Address3}{$.Phone}",
                "container.Address1": function (Address1) {
                    return Address1 ? "<p>" + Address1 + "</p>" : "";
                },
                "container.Address2": function (Address2) {
                    return Address2 ? "<p>" + Address2 + "</p>" : "";
                },
                "container.Address3": function (Address3) {
                    return Address3 ? "<p>" + Address3 + "</p>" : "";
                },
                "container.Phone": function (Phone) {
                    return Phone ? '<p class="phone">' + Phone + "</p>" : "";
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
		this.mapObj = new google.maps.Map(document.getElementById('map_canvas'), this.mapOptions);
		this.getArtists();
	},
	
	getGeoLocation: function () {
		//if geoLocation is, set default location
		var self = this, infowindow = undefined;
		
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
			    self.mapOptions.center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			    self.mapOptions.zoom = 12;
			    
			    //display default message - although, if they are members we could welcome them back?
			    infowindow = new google.maps.InfoWindow({
			      map: self.mapObj,
			      position: self.mapOptions.center,
			      content: "Let's find artists near you!"
			    });

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
							content: "this should be the content that is displayed",
							position: mylatlng
						});
						
						google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(self.mapObj,mymarker);
							self.mapObj.panTo(mylatlng);
						});				
					
					} )(marker, latlng);			

				}
            }
        });
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
