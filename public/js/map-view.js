
var map;
var geocoder;
var markerCluster;
var ib;

function codeAddress() {
    var address = document.getElementById("location").value;
    if(address) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            }
        });
    }
}

function initialize() {
    geocoder = new google.maps.Geocoder();

    map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 9,
        center: new google.maps.LatLng(44.65,-63.6)
    });

    codeAddress();

    google.maps.event.addListener(map, 'idle', function() {
        loadRentals();
    });

}

function showRentals(ids, marker, cluster) {

    $('#spinner').show();

    if(ids.constructor === Array) {
        ids = ids.join(',');
    }

    $.ajax({
        type: 'GET',
        url: '/map-list',
        data: {ids: ids},
        success: function (data, textStatus, jqXHR) {

            if(cluster) {
                marker = cluster.getMarkers()[0];
            }
            var boxText = document.createElement("div");
            // boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: white; padding: 5px;";
            boxText.innerHTML = data;

            var myOptions = {
                content: boxText,
                disableAutoPan: false,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-140, 0),
                zIndex: null,
                boxStyle: {
                    background: "url('/images/tipbox.gif') no-repeat",
                    width: "280px"
                },
                closeBoxMargin: "10px 2px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: true,
                contextmenu: true
            };

            if(ib) {
                ib.close();
            }
            ib = new InfoBox(myOptions);
            ib.open(map, marker);



        },
        error: function (jqXHR, textStatus, errorThrown) {

            alert(errorThrown);

        },

        complete: function (jqXHR, textStatus) {

            $('#spinner').hide();

        }
    });
}

function loadRentals() {

    if(ib) {
        ib.close();
    }

    $('#spinner').show();

    var bounds = map.getBounds();
    var N = bounds.getNorthEast().lat();
    var S = bounds.getSouthWest().lat();
    var W = bounds.getSouthWest().lng();
    var E = bounds.getNorthEast().lng();

    var markers = [];

    $.ajax({
        type: 'GET',
        url: '/markers?N=' + N + '&S=' + S + '&W=' + W + '&E=' + E,
        data: $('#search').serialize(),
        success: function (data, textStatus, jqXHR) {

            for (var i=0; i < data.length; i++ ) {
                var latLng = new google.maps.LatLng(data[i].lat, data[i].lng);
                var marker = new google.maps.Marker({position: latLng, id: data[i].uuid});
                google.maps.event.addListener(marker, 'click', function() {
                    showRentals(this.id, this);
                });
                markers.push(marker);
            }

            if(markerCluster) {

                markerCluster.clearMarkers();
                markerCluster.addMarkers(markers);

            } else {

                markerCluster = new MarkerClusterer(map, markers, {zoomOnClick: false});

                google.maps.event.addListener(markerCluster, 'clusterclick', function (cluster) {

                    var ids = [];

                    var markers = cluster.getMarkers();

                    for (var i=0; i <markers.length; i++ ) {
                        ids.push(markers[i].id);
                    }

                    showRentals(ids, null, cluster);
                });
            }

        },

        error: function (jqXHR, textStatus, errorThrown) {

            alert(errorThrown);

        },

        complete: function (jqXHR, textStatus) {

            $('#spinner').hide();

        }
    });
}

$(document).ready(function() {
 // TODO: Talk to Matt about this
    // if larger than the 772px breakpoint, set map to 100% of viewport, minus the height of the header
   if ($(window).width() > 772) {
        resizeMap();
   }
    window.onresize = function(event) {
      resizeMap();
    }    
    function resizeMap() {
      vpw = $(window).width();
      vph = $(window).height() - 111;
      $('#map-canvas').css({'height': vph + 'px'});
    }

   $('#spinner').hide();

    $(".selectmenu").selectmenu({
        change: function( event, ui ) {
            loadRentals();
        },
        appendTo:".filter",
        icons:{button:"ui-icon-arrowthick-1-s"}});

    $('#location').select2({
        placeholder: 'City',
        minimumInputLength: 3,
        ajax: {
            url: '/location-list',
            dataType: 'json',
            data: function (term, page) {
                return {
                    location: term
                };
            },
            processResults: function (data, page) {
                return {results: data};
            }
        }
    });

    $('#location').on("change", function(e) {
        codeAddress();
    });


    initialize();
    map.set('disableDoubleClickZoom', true);

});
// Disable mousewheel and dragging while mousing over the infowindow
$(document).on("mouseenter", ".hits", function(){
  map.setOptions( {draggable:false, scrollwheel:false} );
});
$(document).on("mouseleave", ".hits", function(){
  map.setOptions( {draggable:true, scrollwheel:true} );
});
