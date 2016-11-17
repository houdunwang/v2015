!function ($) {

  $(function(){
		map = new GMaps({
			div: '#gmap_geocoding',
			lat: 40.0000,
			lng: -100.0000,
			zoom: 4
		});

		map.addMarker({
			lat: 40.0000,
			lng: -100.0000,
			title: 'Marker',
			infoWindow: {
				content: 'Info content here...'
			}
		});

		$('#geocoding_form').submit(function(e){
			e.preventDefault();
			GMaps.geocode({
			  address: $('#address').val().trim(),
			  callback: function(results, status){
			    if(status=='OK'){
			      var latlng = results[0].geometry.location;
			      map.setCenter(latlng.lat(), latlng.lng());
			      map.addMarker({
			        lat: latlng.lat(),
			        lng: latlng.lng()
			      });
			    }
			  }
			});
		});

  });
}(window.jQuery);