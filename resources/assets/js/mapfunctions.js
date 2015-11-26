
//Variable declaration
var map;
var startpoint;
var endpoint;
var startaddress;
var endaddress;
var locationsObject = {};
var markersArray = [];


//MAP INITIALISATION FUNCTION - Load map if there is a div with id = map
if ( $( "#map" ).length )
    {
    console.log('this page has a map');

    window.gMapsCallback = function()
        {

            $(window).trigger('gMapsLoaded');

        }

    $(document).ready((function()
    {

        function initialize()
        {
            //Create placeholder map with default settings
            //TODO centre on user's location by default
            var defaultOptions =
            {
                zoom: 8,
                center: new google.maps.LatLng(-34.397, 150.644),
                streetViewControl: false

            };

            map = new google.maps.Map(document.getElementById('map'),defaultOptions);

        }

        function loadGoogleMaps()
        {
            //Load google javascript library
            var script_tag = document.createElement('script');
            script_tag.setAttribute("type","text/javascript");
            script_tag.setAttribute("src","http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
            (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);

        }

        $(window).bind('gMapsLoaded', initialize);
        loadGoogleMaps();

        })());

    }




//GEOLOCATION FUNCTION Geolocate the addresses provided by the user when button is clicked
$( "#show_on_map" ).click( function()
{
    //Code address inputs into url strings
    startaddress = $( "#startaddress").val().replace(/ /g, '+');
    endaddress = $( "#endaddress").val().replace(/ /g, '+');
    //TODO REPLACE ADDRESSES WITH RETURNED ADDRESS FROM AJAX

    //Reset hidden form element to null on each click
    $("#startpoint").val(null);
    $("#endpoint").val(null);

    //Initialise variables and clear existing markers
    var addresses = [ startaddress, endaddress ];
    var bounds = new google.maps.LatLngBounds();
    clearOverlays();

    //Loop through each address to geolocate via ajax
    var ajaxArray = [];
    for (var i = 0; i < addresses.length; i++)
    {

        (function(i)
        {
            ajaxArray.push($.ajax(
                {
                    dataType: "json",
                    url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[i]+'&sensor=false',
                    data: null,
                    success: handleData

                }));


            function handleData(data, string, jqXHR)
            {
                //Geocode addresses
                var geocode = data.results[0].geometry.location;
                var latlng = new google.maps.LatLng( geocode.lat, geocode.lng );


                //Make Marker for each address
                var marker = new google.maps.Marker(
                    {
                        position: latlng,
                        map: map
                    });
                markersArray.push(marker);

                //Extend bounds to fit markers
                bounds.extend(latlng);
                map.setCenter(bounds.getCenter());
                map.fitBounds(bounds);

                //store geolocated coordinates to object for later usage
                var a = 'location' + i;
                locationsObject[a] = {lat: geocode.lat, lng: geocode.lng};

            }
        })(i);


    }
   //Reset zoom so that no marker is on the edge of the map
   map.setZoom(map.getZoom()-1);


    //Only trigger this function when the ajax calls are completed
    $.when(ajaxArray[0],ajaxArray[1]).done
    (
        function()
            {
                //Get coordinates of start and end points to store in db
                startpoint  =   locationsObject.location0.lat + " " + locationsObject.location0.lng;
                endpoint    =   locationsObject.location1.lat + " " + locationsObject.location1.lng;

                //Need to validate start and endpoints due to DB raw command
                var validate = new RegExp(/^[\d\-\s\.]+$/);
                var allow_startpoint = validate.test(startpoint);
                var allow_endpoint = validate.test(endpoint);

                //Only insert into HTML if both are true
                if(allow_startpoint == true && allow_endpoint == true)
                {
                    $("#startpoint").val(startpoint);
                    $("#endpoint").val(endpoint);
                }
                else
                {
                    $("#startpoint").val(null);
                    $("#endpoint").val(null);
                }

                //Set hidden form elements to equal the coordinates of the start and endpoint

            }
    );

});



//Remove any markers previously on map
function clearOverlays() {
    if (markersArray) {
        for (var i=0; i<markersArray.length; i++)
        {
            markersArray[i].setMap(null);
        }
    }
}


