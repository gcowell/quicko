/**********************************************************************************************************
OBJECT CLASSES
 **********************************************************************************************************/

/**
 * MAPOBJECT CLASS.
 *
 * This class handles all map functions
 * and properties
 */
function MapObject()
{
    var map;

    this.startpoint = null;
    this.endpoint = null;

    this.startaddressURL = null;
    this.endaddressURL = null;

    this.ajaxArray = [];
    this.addressURLArray = [];
    this.locationsArray = {};
    this.markersArray = [];
    this.matchesArray = [];

    this.mapBounds = null;

    $(window).bind('gMapsLoaded', this.LoadGoogleMap);

    window.gMapsCallback = function()
    {
        $(window).trigger('gMapsLoaded');
    }

    this.LoadMapScript();

};



/*********************************************************************************
 * METHOD LoadMapScript.
 * Appends a script tag with Google maps API
 */
MapObject.prototype.LoadMapScript = function()
{
    var script = document.createElement("script");
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback";
    script.type = "text/javascript";
    document.getElementsByTagName("head")[0].appendChild(script);
}



/*********************************************************************************
 * METHOD LoadGoogleMap.
 * Creates a map in document element
 * with default options
 */
MapObject.prototype.LoadGoogleMap = function()
{
    var mapStartOptions =
    {
        zoom: 8,
        center: new google.maps.LatLng(-33.8650, 151.2094),
        //TODO make this centre on user's locations
        streetViewControl: false
    };
    map = new google.maps.Map(document.getElementById('map'),mapStartOptions);
}



/*********************************************************************************
 * METHOD encodeAddressURLs.
 * Formats address inputs with '+'
 * signs to prepare for AJAX url
 */
MapObject.prototype.encodeAddressURLs = function()
{
    //TODO strip illegal chars, eg. commas etc.

    this.startaddressURL = $( "#startaddress").val().replace(/ /g, '+');
    this.endaddressURL = $( "#endaddress").val().replace(/ /g, '+');

    this.addressURLArray = [ this.startaddressURL, this.endaddressURL ];
}



/*********************************************************************************
 * METHOD clearHiddenInputs.
 * Remove existing entries in
 * hidden form elements
 */
MapObject.prototype.clearHiddenInputs = function()
{
    $("#startpoint").val(null);
    $("#endpoint").val(null);
}


/*********************************************************************************
 * METHOD clearOverlays.
 * Clear any existing location markers
 * on the map
 */
MapObject.prototype.clearOverlays = function ()
{
    if (this.markersArray.length != 0)
    {
        for (var i=0; i<this.markersArray.length; i++)
        {

            this.markersArray[i].setMap(null);
        }
    }
}


/*********************************************************************************
 * METHOD geocodeAddresses.
 * AJAX calls to Google to obtain
 * latitude / longitude for each location
 */
MapObject.prototype.geocodeAddresses = function(markersRequired)
{

    for (var i = 0; i < this.addressURLArray.length; i++)
    {
        (function(i)
        {
            this.ajaxArray.push(
                $.ajax(
                {
                    dataType: "json",
                    url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+this.addressURLArray[i]+'&sensor=false',
                    data: null,
                    context: this,
                    success: handleData

                }));

                    function handleData (data)
                    {

                        var geocode = data.results[0].geometry.location;
                        var index = 'location' + i;
                        this.locationsArray[index] = {lat: geocode.lat, lng: geocode.lng};

                    }

        }).call(this, i);
    }

    if(markersRequired)
    {
        $.when.apply($, this.ajaxArray).done
        (
            $.proxy
            (
                function()
                {

                    this.createMarkers.call(this, null);

                },this
            )
        )
    }
}


/*********************************************************************************
 * METHOD createMarkers.
 * Place markers on map for geolocated
 * points. Resets view to centre on markers
 */
MapObject.prototype.createMarkers  = function()
{

    this.mapBounds = new google.maps.LatLngBounds();

    for (var i in this.locationsArray)
    {
        if (!this.locationsArray.hasOwnProperty(i))
        {
            //The current property is not a direct property
            continue;
        }

        (function(i)
        {

            var marker_coords = this.locationsArray[i];
            var lat = marker_coords.lat;
            var lng = marker_coords.lng;

            var latlng = new google.maps.LatLng( lat, lng );
            var marker = new google.maps.Marker
            (
                {
                position: latlng,
                map: map
                }
            );

            this.markersArray.push(marker);
            this.mapBounds.extend(latlng);
            map.setCenter(this.mapBounds.getCenter());
            map.fitBounds(this.mapBounds);

        }).call(this, i);

    }

    map.setZoom(map.getZoom()-1);

}



/*********************************************************************************
 * METHOD validatePoints.
 * Ensure points are numeric
 */
MapObject.prototype.validatePoints  = function()
{

    var validate = new RegExp(/^[\d\-\s\.]+$/);
    var allow_startpoint = validate.test(this.startpoint);
    var allow_endpoint = validate.test(this.endpoint);

    //Only insert into HTML if both are true
    if(allow_startpoint == true && allow_endpoint == true)
    {
        return true
    }
    else
    {
        return false
    }

}


/*********************************************************************************
 * METHOD preparePoints.
 * Insert points into hidden
 * form elements
 */
MapObject.prototype.preparePoints  = function()
{

    this.startpoint  =   this.locationsArray.location0.lat + " " + this.locationsArray.location0.lng;
    this.endpoint    =   this.locationsArray.location1.lat + " " + this.locationsArray.location1.lng;

    var checkPoints = this.validatePoints.call(this, null);

    if (checkPoints = true)
    {
        $("#startpoint").val(this.startpoint);
        $("#endpoint").val(this.endpoint);
    }
    else
    {
        $("#startpoint").val(null);
        $("#endpoint").val(null);
    }

}



/*********************************************************************************
 * METHOD getResults.
 * Return journeys within a given
 * range from parcel
 */
MapObject.prototype.getResults = function (range)
    {
        this.matchesArray = [];
        var url = window.location.pathname;
        var params = url.split('/');
        var parcel_id = params[params.length -2];

        $.ajax(
            {
                dataType: "json",
                url: 'http://quicko/parcels/'+parcel_id+'/'+range,
                data: null,
                context: this,
                success: plotData
            });

                function plotData(data)
                {
                    {

                        //DEAL WITH PARCEL
                        var parcel_start_lat = data.parcel.start_lat;
                        var parcel_start_lng = data.parcel.start_lng;

                        var parcel_end_lat = data.parcel.end_lat;
                        var parcel_end_lng = data.parcel.end_lng;

                        this.clearOverlays.call(this, null);

                        this.plotCircle.call(this, parcel_start_lat, parcel_start_lng, range);
                        this.plotCircle.call(this, parcel_end_lat, parcel_end_lng, range);

                        //DEAL WITH JOURNEYS
                        var resultsArray = data.matches;

                        for (var i = 0; i < resultsArray.length; i++)
                        {
                            var match = resultsArray[i];
                            this.plotResultMarkers.call(this, match);
                        }

                        map.setZoom(map.getZoom()-1);

                        this.matchesArray.push(match);

                    }
                }

    }




/*********************************************************************************
 * METHOD plotResultMarkers.
 * Plot markers and routes for
 * each matching result
 */
MapObject.prototype.plotResultMarkers = function (match)
{



    //TODO push markers into the match object, then push each match object into the match Array

    var start_latlng = new google.maps.LatLng( match.start_lat, match.start_lng);
    var end_latlng = new google.maps.LatLng( match.end_lat, match.end_lng);
    var match_id = match.id;


    var start_marker = new google.maps.Marker
    (
        {
            position: start_latlng,
            map: map,
            icon: '/img/journey_icon.png',
            id: match_id
        }
    );

    var end_marker = new google.maps.Marker
    (
        {
            position: end_latlng,
            map: map,
            icon: '/img/journey_icon.png',
            id: match_id
        }
    );


    var route = new google.maps.Polyline
    (
        {
        path: [start_latlng, end_latlng],
        geodesic: true,
        map: map,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2,
        id: match_id
        }
    );

    this.markersArray.push(start_marker);
    this.markersArray.push(end_marker);
    this.markersArray.push(route);

    this.mapBounds = new google.maps.LatLngBounds();
    this.mapBounds.extend(start_latlng);
    this.mapBounds.extend(end_latlng);
    map.setCenter(this.mapBounds.getCenter());
    map.fitBounds(this.mapBounds);

}




/*********************************************************************************
 * METHOD plotCircle
 * Plots a circle of radius 'range'
 * around a point
 */
MapObject.prototype.plotCircle = function (lat, lng, range)
{

    var latlng = new google.maps.LatLng( lat, lng );
    var marker = new google.maps.Marker
    (
        {
            position: latlng,
            map: map,
            icon: '/img/parcel_icon.png'
        }
    );
    this.markersArray.push(marker);

    var circle = new google.maps.Circle
    (
        {
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: latlng,
        radius: range * 1609.34
        }
    );
    this.markersArray.push(circle);

}






/**********************************************************************************************************
PROCEDURES AND HANDLERS
 **********************************************************************************************************/

$(document).ready((function()
    {
        var defaultRange = 10;

        /*********************************************************************************
         * HANDLER rangeSlider.
         * Loads slider if rangeslider DOM element
         * is found on page
         */
        if ( $( "#rangeslider" ).length )
        {
            $( "#rangeamount" ).val( defaultRange + " miles" );
            $(function()
            {
                $( "#rangeslider" ).slider
                (
                    {
                        min: 1,
                        max: 30,
                        value: defaultRange,
                        slide: function( event, ui )
                        {
                            $( "#rangeamount" ).val( ui.value + " miles" );
                        }
                    }
                );
            });
        }


        /*********************************************************************************
         * HANDLER loadMap.
         * Loads map if map DOM element
         * is found on page
         */
        if ( $( "#map" ).length )
        {
            var quickomap = new MapObject();

        }



        /*********************************************************************************
         * HANDLER getInitialResults.
         * Loads results if match URL
         * is found
         */
        if(window.location.href.indexOf("default") > -1) //TODO I would prefer "defaultmatch"
        {
            quickomap.getResults.call(quickomap, defaultRange);
        }



        /*********************************************************************************
         * HANDLER getNewResults.
         * Loads results on update
         * map click button
         */
        $( "#updatemap" ).click(function()
        {

            var range = $( "#rangeslider").slider("value");
            quickomap.getResults.call(quickomap, range);

        });



        /*********************************************************************************
         * HANDLER showPointsOnMap.
         * Plots points on map
         * for a given pair of addresses
         */
        $( "#show_on_map" ).click(function()
        {
            quickomap.clearHiddenInputs;
            quickomap.encodeAddressURLs.call(quickomap, null);
            quickomap.clearOverlays.call(quickomap, null);

            var markersRequired = true;
            quickomap.geocodeAddresses.call(quickomap, markersRequired);

            $.when.apply($, quickomap.ajaxArray).done
                (
                    $.proxy
                    (
                        function()
                        {

                            quickomap.preparePoints.call(quickomap, null);

                        },quickomap
                    )
                )
        });

    })());

