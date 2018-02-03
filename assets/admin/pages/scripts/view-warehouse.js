
var usersCount = 0;
var datapart = '';
var alertUsersData = {};
var contentstring = [];
var regionlocation = [];
var markers = [];
var iterator = 0;
var areaiterator;
var map;
var infowindow = [];

var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var catCheckVal = false;
$( "#warename" ).on('keyup change paste',function(){
    var catnem = $("#catname").val();
    var urlpart = "check-category";
    datapart = {catname: catnem};
    if(catnem != ''){
        $.ajax({
            type: "POST",
            url: urlpart,
            data: datapart,
            dataType: "html",           
            complete: function (response) {
                if(response.status == 200){
                    var res = response.responseText;
                    if(res == 'true'){
                        catCheckVal = 'false';
                        $('#warecheck').attr('class','fa fa-close');
                    }else{
                        catCheckVal = 'true';
                        $('#warecheck').attr('class','fa fa-check-circle');
                    }
                }

            },
        });
    }else{
        $('#catcheck').attr('class','');
    }

});
//--On Body Load Set Image File Value
function chkAtLstOneInGroupChkBx() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function () {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  // Do something with atLeastOneIsChecked
}


function DriverImageURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function VehicleImageURL(input,val,imgTagId) {
    if(validate_uploadfile_format(val,'image') == 'true'){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+imgTagId)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }else{
        $('#'+imgTagId).attr('src', 'http://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png');
    }        
}

//-- Created By N.K.
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) == false ? false : true;
    }
    
    //--- Validate input file extension
    function validate_uploadfile_format(fileName,filterType)
    {
         
        var allowed_extensions1  = new Array("jpeg","jpg","png","gif");
        var allowed_extensions2  = new Array("pdf","doc","docs");
        var allowed_extensions12 = new Array("jpeg","jpg","png","gif","pdf","doc","docx");
        
        var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

        if(filterType == 'image'){
            for(var i = 0; i <= allowed_extensions1.length; i++)
            {
                if(allowed_extensions1[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        if(filterType == 'docs'){
            for(var i = 0; i <= allowed_extensions2.length; i++)
            {
                if(allowed_extensions2[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        if(filterType == 'imgdocs'){
            for(var i = 0; i <= allowed_extensions12.length; i++)
            {
                if(allowed_extensions12[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        
        
        return 'false';
    }
  

    
    //-- Created By N.K.
    function setFeedError(ele, dpart) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.removeClass("hide");
            element.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+dpart);
        }else{ 
            element.html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+dpart);
        }
    }

    //-- Created By N.K.
    function washFeedError(ele) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.html("");
        }else{
            element.addClass("hide");
            element.html("");
        }
    }
    
    //-- Validate Group Check Box for Modules
    $(document).on("click",".groupchk",function() {//disable both popup      
       var checkboxs=document.getElementsByClassName("groupchk");
        var okay=false;
        for(var i=0;i< checkboxs.length;i++)
        {
            if(checkboxs[i].checked)
            {
                okay=true;
                break;
            }
        }
        if(okay){$('#selectedModules').val(true);}
        else{$('#selectedModules').val(''); }
    });
    
    //--- Validate Form Submission 
    $("#addWarehouse").submit(function(event){ 
        var phone_regex = /^[0-9]{10,12}$/;
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var link_regex  = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        var error = [];
        var warename    = $('#warename').val();
        var address     = $('#address').val(); // <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        
        //--- First Name Validation
        if(warename == '' || warename == undefined){
            setFeedError('warename-error','required field');
            error['warename'] = true;
        }
        else if(warename.length < 5){
            setFeedError('warename-error','can\'t be less than 5 chars');
            error['warename'] = true;
        }
        else if(warename.length > 50){
            setFeedError('warename-error','can\'t exceed 50 chars');
            error['warename'] = true;
        }
        else{
            washFeedError('warename-error');
            error['warename'] = false;
        }
        
        //--- Last NameValidation
        if(address == '' || address == undefined){
            setFeedError('address-error','required field');
            $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i><p style="color:red;font-size:11px;"> Please find your address by clicking on Map & dragging the marker');
            error['address'] = true;
        }
        else{
            washFeedError('address-error');
            error['address'] = false;
        }
        
        
        if(error['warename'] == false && error['address'] == false){
            return true;
        }else{
            return false;
        }


    });
    
    
    
    
//--- Google Map 
var ilat = 0.0; var ilng = 0.0;
if($('#latlng').val() != ''){
    var ilatlng = $('#latlng').val().split(",");
    ilat = ilatlng[0];
    ilng = ilatlng[1];
}else{
    ilat = 55.86336763758299;
    ilng = -4.222869873046875 ;
}
    
//---- Map JS 
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: parseFloat(ilat), lng: parseFloat(ilng)},  // -21.772488, 131.564276
      zoom: 4
    });
    var geocoder = new google.maps.Geocoder();
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    
    var markerPos = new google.maps.LatLng(parseFloat(ilat), parseFloat(ilng));
    var marker = new google.maps.Marker({
        map: map,
        position: markerPos,
        draggable: true, //make it draggable
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
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
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(8);
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
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);

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
                    $('#latlng'). val(inLatLng);
                  }
                  else{
                      $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                      $('#address').val('');
                      $('#latlng'). val('');
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
                $('#latlng'). val(inLatLng);
              }
              else{
                  $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                  $('#address').val('');
                  $('#latlng'). val('');
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
                $('#address'). val(results[0].formatted_address);
                $('#latlng'). val(inLatLng);
              }
              else{
                  $('#whaddress').html('<i style="font-weight:200 !important;"> Not set yet </i>');
                  $('#address').val('');
                  $('#latlng'). val('');
              }
            }
        });
    });
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

