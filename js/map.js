// Set global variables
var map;
var bounds = new google.maps.LatLngBounds();

// Initialization function
function initialize() {
	var mapOptions = {
		mapTypeId: 'roadmap'
	};
	if(jQuery('#map-canvas')[0]){
	
	console.log(jQuery('#map-canvas')[0])
	

	// Display a map on the page
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	map.setTilt(45);

	// Display multiple markers on a map
	var infoWindow = new google.maps.InfoWindow(), marker, i;

	// Loop through our array of markers & place each one on the map
	for( i = 0; i < markers.length; i++ ) {
		var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
		bounds.extend(position);
		var image = {
			url: 'https://surgicalmicroscopes.com/wp-content/themes/prescotts/img/map-marker.png',
			size: new google.maps.Size(24, 36),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(12, 36),
			scaledSize: new google.maps.Size(24, 36)
		};
		marker = new google.maps.Marker({
			position: position,
			map: map,
			icon: image,
			title: markers[i][0]
		});

		// Allow each marker to have an info window
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infoWindow.setContent(infoWindowContent[i][0]);
				infoWindow.open(map, marker);
			}
		})(marker, i));

		// Automatically center the map fitting all markers on the screen
		map.fitBounds(bounds);

		// Custom styles for map
		map.set('styles', [
			{"featureType":"water","elementType":"geometry","stylers":[{"color":"#d3e1ff"},{"lightness":17}]},
			{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"lightness":20}]},
			{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#d3d3d3"},{"lightness":17}]},
			{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#d3d3d3"},{"lightness":29},{"weight":0.2}]},
			{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e2e2e2"},{"lightness":18}]},
			{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},
			{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"lightness":21}]},
			{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},
			{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},
			{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},
			{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}
		]);

	}
	}

}

// Initialize map on load
google.maps.event.addDomListener(window, 'load', initialize);

// Listen for events after map initialization
google.maps.event.addDomListener(window, 'resize', function() {
	google.maps.event.trigger(map, 'resize');
	map.fitBounds(bounds);
});
