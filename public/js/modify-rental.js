

$('#available').datepicker();

$('#modify_rental_form').submit(function(event) {


    event.preventDefault();

    var rentalForm = $(this);

    var streetAddress = $('#street_address').val();
    var city = $('#city').val();
    var province = $('#province').val();
    var postal_code = $('#postal_code').val();

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

    var address = '';

    if( ! postal_code) {
        address = streetAddress + ',' + city + ',' + province;
    } else {
        address = streetAddress + ',' + city + ',' + province + ',' + postal_code;
    }

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
                county_result = 0;
            }

            $('#city').val(city_result);

            if(city_result != city) {

                showModal('<strong>We are having trouble finding that location.</strong></p>' +
                    '<p>We have changed the city to <strong>' + city_result + '<strong></p>' +
                    '<p>How should I format my address to ensure my property address is accepted?</p><ul>' +
                    '<li>Specify addresses in accordance with the format used by Canada Post</li>' +
                    '<li>Ensure that the spelling is correct for Street Address and City</li>' +
                    '<li>Use standard abbreviations, either short or long form. Street = St, Road = Rd. etc.</li>' +
                    '<li>Do not specify additional address elements such as business names, floor numbers, etc.</li>' +
                    '<li>Use the street number of a premise in preference to the building name where possible.</li>' +
                    '<li>Use street number addressing in preference to specifying cross streets where possible.</li>' +
                    '<li>Do not provide "hints" such as nearby landmarks.</li>' +
                    '<li>Try your address in <a href="http://googlemaps.com">googlemaps.com</a> and see if it brings you to your property.</li>' +
                    '<li>If you cannot get your exact position try left clicking on the map at <a href="http://googlemaps.com">googlemaps.com</a> to get the closest possible location.</li></ul><p>');
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


