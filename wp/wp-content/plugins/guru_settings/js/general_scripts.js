jQuery(document).ready(function($){

    if( pagenow == 'toplevel_page_guru_settings/index' ){
       guru_show_map_preview();
    }
    $('#geocode').on('click',function(e){
        e.preventDefault();

        var address = $('input[name=guru_map_address]').val()

        if( address == '' ){
            alert('Please enter an address.');
            return false;
        }

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address }, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) {

            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            $('#guru_location_coordinates').val( lat + ',' + lng );
            guru_show_map_preview();

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    });
    // show map
   
    function guru_show_map_preview(){
      var coordinates = $('#guru_location_coordinates').val();

      if( coordinates != '' ){
          $('#map-preview').css({'height':'150px','width':'250px','margin-top':'20px'})

           $('#map-preview').googleMap({
               'coordinates' : coordinates,
               'zoom' : 15,
               'infobox' : false,
               'longitude' : '',
               'latitude' : ''
           });
      }
    }


});