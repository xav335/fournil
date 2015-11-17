/* Slider */
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    autoplay: 7000,
	autoplayDisableOnInteraction: false,
	loop: true
});

/* Foundation */
$(document).foundation();


/* Google maps */
var map;
function initialize() {

	var mapOptions = {
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		zoom: 13,
		zoomControl: false,
		panControl: false,
		streetViewControl: false,
		scrollwheel: false,
		scaleControl: false,
		overviewMapControl: false,
		center: new google.maps.LatLng(44.855043, -0.4985679999999775)
	};
	
	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	
	var mapStyles = [
		{
			"featureType": "landscape",
			"stylers": [
				{ "visibility": "on" },
				{ "color": "#550105" }
			]
		},{
			"featureType": "water",
			"stylers": [
				{ "visibility": "on" },
				{ "color": "#5a0106" }
			]
		},{
			"featureType": "water",
			"elementType": "labels",
			"stylers": [
				{ "visibility": "off" }
			]
		},{
			"featureType": "administrative",
			"stylers": [
				{ "visibility": "off" }
			]
		},{
			"featureType": "administrative",
			"elementType": "labels",
			"stylers": [
				{ "visibility": "simplified" },
				{"color": "#88080e"}
			]
		},{
			"featureType": "poi",
			"stylers": [
				{ "visibility": "off" }
			]
		},{
			"featureType": "road",
			"stylers": [
				{ "visibility": "on" },
				{ "color": "#ff0000" }
			]
		},{
			"featureType": "road.arterial",
			"stylers": [
			{"visibility": "simplified"},
			{"color": "#510105"}
			]
		},{
			"featureType": "road.highway",
			"stylers": [
			{"visibility": "simplified"},
			{"color": "#88080e"}
			]
		},{
			"featureType": "road.local",
			"stylers": [
				{ "visibility": "simplified" },
				{ "color": "#510105" }
			]
		},{
			"featureType": "transit",
			"stylers": [
				{ "visibility": "off" }
			]
		}
	];
	
	map.setOptions({styles: mapStyles});
	
	var icon = {
		path: 'M16.5,51s-16.5-25.119-16.5-34.327c0-9.2082,7.3873-16.673,16.5-16.673,9.113,0,16.5,7.4648,16.5,16.673,0,9.208-16.5,34.327-16.5,34.327zm0-27.462c3.7523,0,6.7941-3.0737,6.7941-6.8654,0-3.7916-3.0418-6.8654-6.7941-6.8654s-6.7941,3.0737-6.7941,6.8654c0,3.7916,3.0418,6.8654,6.7941,6.8654z',
		anchor: new google.maps.Point(16.5, 51),
		fillColor: '#FF0000',
		fillOpacity: 0.6,
		strokeWeight: 0,
		scale: 0.66
	};
	
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(44.855043, -0.4985679999999775),
		map: map,
		icon: icon,
		title: 'Les Fournils de Jean-Philippe - 5 Bis Avenue Virecourt Artigues, Aquitaine, France'
	});
}

google.maps.event.addDomListener(window, 'load', initialize);