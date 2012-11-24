define([
	'jQuery',
	'Underscore',
	'Backbone',
	'jsonT'
], function($, _, Backbone, jsonT){

var Artify = Artify || {};
	
	Artify.map = {
	        //should be one off initialising for this first bit
	        mapObj: undefined,
	        infowindow: undefined,
	        markersArray: [],
	        marker: undefined,
	        geocoder: undefined,
	        jsonUrl: '/api/allartists',
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
		                                avatar
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
	                if (!this.getGeoLocation()) {
	                        console.log('geolocation isn\'t available, prompt user');
	                } else {
	                        console.log('tell user to drag the marker to their address, or enter an address');
	                };
	                //draw the map
	                this.mapObj = new google.maps.Map(document.getElementById('map'), this.mapOptions);
	                //GEOCODER
	                this.geocoder = new google.maps.Geocoder();
	                this.autoComplete();
	                this.getArtists();
	                this.attachEvents();
	        },
	        
	        userInit: function () {
	                //if available, set geoLocation, otherwise defaults will display
	                if (!this.getGeoLocation()) {
	                        console.log('geolocation isn\'t available, prompt user');
	                } else {
	                        console.log('tell user to drag the marker to their address, or enter an address');
	                };
	                //draw the map
	                this.mapObj = new google.maps.Map(document.getElementById('map'), this.mapOptions);
	                //GEOCODER
	                this.geocoder = new google.maps.Geocoder();
	                this.autoComplete();
	        },
	        
	        getGeoLocation: function () {
	                //if geoLocation is, set default location
	                var self = this, infowindow = undefined;
	                
	                if(navigator.geolocation) {
	                        navigator.geolocation.getCurrentPosition(function(position) {
	                                self.mapOptions.zoom = 6;
	                            self.mapOptions.center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	                                self.marker = new google.maps.Marker({
	                                        map: self.mapObj,
	                                        position: self.mapOptions.center,
	                                        draggable: true
	                                });
	                            infowindow = new google.maps.InfoWindow({
	                              map: self.mapObj,
	                              position: self.mapOptions.center,
	                              content: "If this is not your current location, drag the marker to where you are"
	                            });
	                                self.currentOverlay = infowindow;
	                                infowindow.open(self.mapObj,self.marker);
	                                self.currentOverlay     = infowindow;
	                                self.attachEvents(); 
	                        });
	                        return true;
	                }
	                return false;
	        },
	        
	        setMarker: function () {
	        
	        },
	        
	        getArtists: function () {
	        
	                var self = this;
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
	                                                        content: jsonT({container: jsonData[i]}, Artify.map.filter.artist.jsontTemplate),
	                                                        position: mylatlng
	                                                });
	                                                
	                                                google.maps.event.addListener(marker, 'click', function() {
	                                                        self.clearOverlays();
	                                                        infowindow.open(self.mapObj,mymarker);
	                                                        self.mapObj.panTo(mylatlng);
	                                                        self.currentOverlay     = infowindow;
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
	
            //Add listener to marker for reverse geocoding
            if (self.marker) {
                    google.maps.event.addListener(self.marker, 'drag', function() {
                            self.geocoder.geocode({'latLng': self.marker.getPosition()}, function(results, status) {
                              if (status == google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                  $('#address').val(results[0].formatted_address);
                                  $('#lat').val(self.marker.getPosition().lat());
                                  $('#lon').val(self.marker.getPosition().lng());
                                }
                              }
                            });
                    });
            }
	        },
	        
	        //only one overlay should be displayed
	        clearOverlays: function () {
	                var self = this;
	                if (self.currentOverlay && self.currentOverlay.setMap) {
	                    self.currentOverlay.setMap(null);
	                    return true;
	                }
	                return false;
	        },
	        
	        clearMarkers: function () {
	                if (this.markersArray) {
	                        for (var i = 0; i < this.markersArray.length; i++ ) {
	                                this.markersArray[i].setMap(null);
	                        }
	                }
	        },
	        
	        autoComplete: function () {
	                var self = this;
	                $(document).ready(function() {                            
	                  $(function() {
		                    $("#address").autocomplete({
		                      //This bit uses the geocoder to fetch address values
		                      source: function(request, response) {
		                        self.geocoder.geocode( {'address': request.term }, function(results, status) {
		                          response($.map(results, function(item) {
		                            return {
		                              label:  item.formatted_address,
		                              value: item.formatted_address,
		                              latitude: item.geometry.location.lat(),
		                              longitude: item.geometry.location.lng()
		                            }
		                          }));
		                        })
		                      },
		                      //This bit is executed upon selection of an address
		                      select: function(event, ui) {
		                        $("#lat").val(ui.item.latitude);
		                        $("#lon").val(ui.item.longitude);
		                        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
		                        self.marker.setPosition(location);
		                        self.mapObj.setCenter(location);
		                      }
		                    });
	                  });
	                });
	        }
	};

  	return Artify;
});