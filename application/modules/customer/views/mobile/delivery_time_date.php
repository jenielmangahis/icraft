<script type="text/javascript"> window.areas = JSON.parse('<?php echo json_encode($restrictedAreas); ?>') </script>
<script type="text/javascript"> window.products = JSON.parse('<?php echo json_encode($products); ?>') </script>
<section class="container mobile-view-container">
    <div class="delivery_container">
        <div class="map_container">
            <div class="map_box" id="map_delivery">
            </div>
            <div class="delivery_form">
                <input class="txt-field" type="text" name="address" id="delivery_address" placeholder="Current Address">
                <input class="txt-field" type="hidden" name="delivery_lat_lng" id="delivery_lat_lng">
            </div>
        </div>
        <div class="total_delivery">
            <div class="new_consultation">
                <ul class="d-flex flex-wrap mb-0">
                    <li class="col-6 d-flex flex-nowrap align-items-center justify-content-start">
                        <input type="radio" name="order_type" class="scheduled_type" value="asap" >
                        <label class="col-8 pl-2 pr-0 m-0">
                            <span class="txt">Get Now.</span>
                        </label>
                    </li>
                    <li class="col-6 d-flex flex-nowrap align-items-center justify-content-start">
                        <input type="radio" name="order_type" class="scheduled_type" value="scheduled" >
                        <label class="col-8 pl-2 pr-0 m-0">
                            <span class="txt">Schedule.</span>
                        </label>
                    </li>
                </ul>
            </div>
            <ul class="opposite_detail">
                <li id="asap" style="display: none">
                    <span class="label"><span>On-demand delivery charges:</span></span>
                    <span class="value"><span>3%</span></span>
                </li>
                <li id="scheduled" style="display: none">
                    <span class="label"><span>Scheduled delivery charges:</span></span>
                    <span class="value"><span>1%</span></span>
                    <input class="txt-field" type="text" name="date_time" id="delivery_date_time" placeholder="Select Delivery Date & Time">
                </li>
                <li>
                    <span class="label">Total:</span>
                    <span class="value">$<?=$cartTotal?></span>
                </li>
            </ul>
            <button class="btn gradient change_pass redirect_to_caregiver"><span class="btn-txt">Make Payment</span></button>
        </div>
    </div>
</section>
<div id="notificationModal" class="modal fade" hidden role="dialog">
    <div class="modal-dialog">
        <div class="modal-contact">
            <div class="modal-body">
                <div id="content">
                    <div id="siteNotice">
                    </div> 
                    <div id="bodyContent">
                        <p>`The more app downloads we have in the area, the sooner we can expand there. Share the app with friends and we may get there this month. We're expanding to new towns every week.`</p>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPoiZ1JSZYu_NqSqIGFcRRFEQnzo3yBA&libraries=places&callback=initMap">
</script>
<script>
ilat = 45.513609;
ilng = -122.681460;

$(function(){
    jQuery.datetimepicker.setLocale('en');
    $('input[name=date_time]').datetimepicker();

    // icheck
    $('input[type=radio]').each(function(){
        var self = $(this)

        self.iCheck({
            checkboxClass: 'icheckbox_square-purple',
            radioClass: 'iradio_square-purple',
            increaseArea: '20%'
        });
    });
    $('input[type=radio]').on('ifChecked', function(event){
        var type =  $(event.currentTarget).val();
        if(type ==  'asap'){
            $('#asap').show();
            $('#scheduled').hide();
        }else{
            $('#scheduled').show();
            $('#asap').hide();
        }
    });
});
    
    
    
function initMap() {
    map = new google.maps.Map(document.getElementById('map_delivery'), {
        center: {lat: parseFloat(ilat), lng: parseFloat(ilng)},  // -21.772488, 131.564276
        zoom: 12,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: false
    });
    var geocoder = new google.maps.Geocoder();
    var input = document.getElementById('delivery_address');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    
    var markerPos = new google.maps.LatLng(parseFloat(ilat), parseFloat(ilng));
    var marker = new google.maps.Marker({
        map: map,
        position: {lat: ilat, lng: ilng},
        draggable: true, //make it draggable
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        //infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        
        if (!place.geometry) { window.alert("Autocomplete's returned place contains no geometry"); }
        if (!place.geometry) {
            $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
            $('#address').val('');
        }
  
        if(place.geometry){
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
                map.setZoom(12);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(12);
            }

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);


            var address = '';

            if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');

                let zipCode = place.address_components[5].short_name
                for(area of window.areas)
                {
                    let zipCodes = area.zip_codes.split(',')

                    if ( zipCodes.includes(zipCode) )
                    {
                        // show the alert
                        // this should be done on v1.1 to only show if an THC product exists
                        // in checkout page
                        // check if there is a THC product
                        for(product of products)
                        {
                            if ( product.category_name.toLowerCase() == "thc" )
                            {
                                swal({
                                    html: "<p class='text-left'>We're working around the clock to expand THC delivery to new towns every week and we can mail you CBD products now. But we're very sorry that we don't hand deliver non-CBD products in your area currently. We'll likely expand to your town this month if you share the app with friends because we only need a few dozen customers to launch hand delivery of THC in a town. Help pioneer the next big thing in the cannabis.</p><div class='col-sm-12'> <p class='mb-2'>Sincerely,</p> <p class='mb-2'>Your friends at InstaCraft</p> <p class='mb-2'>Email us anytime at</p> <p class='mb-0'><a href='javascript:;'>staff@getinstacraft.com</a></p> </div>",
                                    showCloseButton: false,
                                    customClass: "alertMap",
                                    showConfirmButton: true,
                                    width: "320px",
                                    confirmButtonClass: "simpleButton"
                                }).then(_ => {
                                    //$('.redirect_to_caregiver').attr('disabled', true)
                                })

                                return false
                            }
                        }
                    }
                }
            }

            var inLatLng = place.geometry.location.lat().toFixed(8) +','+ place.geometry.location.lng().toFixed(8);
            //-- Ftech Address
            geocoder.geocode({
                'latLng': place.geometry.location
                }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (results[0]) {
                    //-- Fetch Address 
                    //alert(results[0].formatted_address);
                    $('#whaddress').html(results[0].formatted_address);
                    $('#address').val(results[0].formatted_address);
                    $('#latlng').val(inLatLng);
                    $('#delivery_lat_lng').val(inLatLng);
                    
                  }
                  else{
                      $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                      $('#address').val('');
                      $('#latlng').val('');
                      $('#delivery_lat_lng').val('');
                  }
                }
            });
        }
    });
    
    //Listen for drag events!
    google.maps.event.addListener(marker, 'dragend', function(event){
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        marker.setPosition(clickedLocation);
        
        var inLatLng = clickedLocation.lat().toFixed(8) + ',' + clickedLocation.lng().toFixed(8);
        //-- Ftech Address
        geocoder.geocode({
            'latLng': event.latLng
            }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                //-- Fetch/Set Address 
                $('#whaddress').html(results[0].formatted_address);
                $('#address').val(results[0].formatted_address);
                $('#latlng').val(inLatLng);
                $('#delivery_lat_lng').val(inLatLng);
              }
              else{
                  $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                  $('#address').val('');
                  $('#latlng').val('');
                  $('#delivery_lat_lng').val('');
              }
            }
        });
    });
    
    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) { 
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        marker.setPosition(clickedLocation);
        
        var inLatLng = clickedLocation.lat().toFixed(8) + ',' + clickedLocation.lng().toFixed(8);   
        //-- Fetch/Set Address 
        geocoder.geocode({
            'latLng': event.latLng
            }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                //-- Fetch Address 
                //alert(results[0].formatted_address);
                $('#whaddress').html(results[0].formatted_address);
                $('#address').val(results[0].formatted_address);
                $('#latlng').val(inLatLng);
                $('#delivery_lat_lng').val(inLatLng);
              }
              else{
                  $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                  $('#address').val('');
                  $('#latlng').val('');
                  $('#delivery_lat_lng').val('');
              }
            }
        });
    });

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)

        geocoder.geocode({
            'location': location
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $("#delivery_address").val(results[0].formatted_address)
            } else {
                console.log('Geocode was not successful for the following reason: ' + status)
            }
        })

        map.setCenter(pos);
      }, function() {
        handleLocationError(true, infowindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infowindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}
///+++ Add Marker for users 
function initMarker(){
    var aCenter=$('#alertCenter').val();
    var aRange=$('#alertRange').val();
    var aMapper=$('#alertMapper').val();
    if(aMapper == '2'){ aRange =  aRange * 1.609344;aRange = Math.round(aRange);  }
    datapart = {alertCenter: aCenter,alertRange : aRange};
    urlpart="getRadiusUsers"; 
    $.ajax({
        type: "POST",
        url: urlpart,
        data: datapart,
        dataType:'json',
        success: function (response) {
            contentstring.length = 0; regionlocation.length = 0;
            contentstring = []; regionlocation = [];
            if(response.status){
                urlpart="hitRadiusPush"; var alertTitle=$('#alertTitle').val(); var alertBody=$('#alertBody').val();
                results = response.result;
                alertUsersData = results;
                itsSize = results.length;
                
                $.each(results, function( key, value ) {
                    //certificate,country,distance,dscr,email,icon,name,plateform,pos,token
                    userdata = value;
                    datapart = {certificate:userdata['certificate'],plateform:userdata['plateform'],token:userdata['token'],dscr:userdata['dscr'],title:alertTitle, body:alertBody, };
                   
                    
                    contentstring.push(userdata['name']+"("+userdata['country']+")");
                    regionlocation.push([userdata['lat'],userdata['lng']]);
                    
                });
                //console.log(itsSize);
                drop();
            }
            else{
                toggleMarkers()
            }
        },
    });
    
}
function drop() {

    if(markers && markers.length !== 0){
        for(var i = 0; i < markers.length; ++i){
            markers[i].setMap(null);
        }
    }
    for (var i = 0; i < usersCount ; i++) {
        //  setTimeout(function() {
            appendMarker(parseFloat(regionlocation[i][0]), parseFloat(regionlocation[i][1]), contentstring[i]);
        //}, 150);
    }
}
function toggleMarkers(){
    for (i = 0; i<markers.length; i++){
            markers[i].setMap(null);
            //markers[i].setMap(map);
    }
}
function appendMarker(latitude, longitude, text) {
    var pos = {lat: latitude, lng: longitude};
    console.log(pos);    
    marker = new google.maps.Marker({
        position: pos,
        map: map,
        icon : 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Azure-icon.png',
        title: text
    });
    markers.push(marker);
    
}
</script>