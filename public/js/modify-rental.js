function showModal(message){
    $('<section id="alert"><p>' + message + '</p></section>').dialog({
        modal: true,
        dialogClass: "noTitle",
        draggable: false,
        resizable: false,
        show: "fade",
        hide: "fade"
    });
}

$('#features').select2();
$('#heats').select2();
$('#appliances').select2();
$('#available').datepicker();

$('#modify_rental_form').submit(function(event) {

    event.preventDefault();

    var rentalForm = $(this);

    var streetAddress = $('#street_address').val();
    var city = $('#city').val();
    var province = $('#province').val();

    if( ! streetAddress) {

        showModal('please provide a street address.');

        return false;
    }
    if( ! city) {
        showModal('Please provide the city.');
        return false;
    }
    if( ! province) {
        showModal('Please provide the province');
        return false;
    }

    var geocoder = new google.maps.Geocoder();

    var address = streetAddress + ',' + city + ',' + province;

    geocoder.geocode({'address': address,

        componentRestrictions: { administrativeArea: province, country: 'CA' }

    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            var county_result;
            var city_result;
            for (var x = 0, length_1 = results.length; x < length_1; x++){
                for (var y = 0, length_2 = results[x].address_components.length; y < length_2; y++){
                    var type = results[x].address_components[y].types[0];
                    if ( type === "administrative_area_level_2") {
                        county_result = results[x].address_components[y].long_name;
                        if (city_result) break;
                    } else if (type === "locality"){
                        city_result = results[x].address_components[y].long_name;
                        if (county_result) break;
                    }
                }
            }


            if( ! county_result) {
                showModal('Sorry, we were not able to find that location.');
                return false;
            }

            if(city_result != city) {

                showModal('We changed the city to ' + city_result);
                $('#city').val(city_result);
                return false;
            }

            var locationResult = results[0].geometry.location;

            $('<input>', {
                type: 'hidden',
                name: 'lat',
                value: locationResult.lat()
            }).appendTo(rentalForm);

            $('<input>', {
                type: 'hidden',
                name: 'lng',
                value: locationResult.lng()
            }).appendTo(rentalForm);

            $('<input>', {
                type: 'hidden',
                name: 'county',
                value: county_result
            }).appendTo(rentalForm);

            rentalForm.unbind('submit');
            rentalForm.trigger('submit');

        } else {
            showModal('We were unable to find that address. Please check your address.');
            return false;
        }
    });

});


