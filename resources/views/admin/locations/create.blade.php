@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Create a New Location</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.locations.store', 'id' => 'create_location_form' ]) !!}

        <label>City
            {!! Form::text('city', null, ['id' => 'city']) !!}
        </label>

        <label for="province">Province
            {!! Form::select('province', Config::get('rentals.provinces'), 'NS', ['id' => 'province', 'autocomplete' => 'off']) !!}
        </label>

        <label id="zoom">Map Zoom Level
            {!! Form::text('zoom', '12') !!}
        </label>

        <br>
        <br>

        {!! Form::submit('Create Location') !!}

        {!! Form::close() !!}
    </section>
@stop

@section('footer')
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">

        $('#create_location_form').submit(function(event) {

            event.preventDefault();

            var locationForm = $(this);

            //if the iuser has already selected a county radio, submit form
            if($("input[name='county']:checked").val()) {
                locationForm.unbind('submit');
                locationForm.trigger('submit');
                return;
            }

            var counties = [];
            var city = $('#city').val();
            var province = $('#province').val();

            if( ! city) {
                showModal('Please provide the city.');
                return false;
            }

            if( ! province) {
                showModal('Please provide the province.');
                return false;
            }

            var geocoder = new google.maps.Geocoder();

            var address = city + ', ' + province;

            geocoder.geocode({'address': address,

                componentRestrictions: { administrativeArea: province, country: 'CA' }

            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {


                    if( ! results.length) {
                        showModal('We were unable to find that address. Please check the address.');
                        return false;
                    }

                    //break down the three dimensional array into simpler arrays
                    for (var i = 0; i < results.length; ++i) {
                        var addressComponents = results[i].address_components;
                        for (var j = 0; j < addressComponents.length; ++j) {
                            var addressTypes = addressComponents[j].types;
                            for (var k = 0; k < addressTypes.length; ++k) {
                                if (addressTypes[k] == "locality") {
                                    var cityResult = addressComponents[j].long_name;
                                }
                                if (addressTypes[k] == "administrative_area_level_2") {
                                    counties.push(addressComponents[j].long_name);
                                }
                            }
                        }
                    }

                    if( city != cityResult) {
                        showModal('We were unable to find that city. Please check the spelling and/or province.');
                        return false;
                    }

                    if(counties.length > 1) {

                        var html = '<label>County</label>';

                        for (var index = 0; index < counties.length; ++index) {
                            html += '<input type="radio" name="county" value="' + counties[index] + '"> ' + counties[index] + '<br>';
                        }

                        $(html).insertAfter("#zoom");

                        showModal('We found multiple places called ' + city + ' in ' + province + '. Please choose the appropriate county.');
                        return false;
                    }

                    if(counties.length === 1) {
                        $('<input>', {
                            type: 'hidden',
                            name: 'county',
                            value: counties[0]
                        }).appendTo(locationForm);
                    }

                    locationForm.unbind('submit');
                    locationForm.trigger('submit');

                } else {
                    showModal('We were unable to find that address. Please check your address.');
                    return false;
                }
            });

        });
    </script>
@endsection