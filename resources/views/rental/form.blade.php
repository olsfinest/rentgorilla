@section('header')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
@stop

<div class="form-group">
    <label for="street_address" class="col-sm-2 control-label">Street Address</label>
    <div class="col-sm-10">
        {!! Form::text('street_address', null, ['class' => 'form-control', 'id' => 'street_address']) !!}
    </div>
</div>
<div class="form-group">
    <label for="city" class="col-sm-2 control-label">City</label>
    <div class="col-sm-10">
        {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city']) !!}
    </div>
</div>
<div class="form-group">
    <label for="province" class="col-sm-2 control-label">Province</label>
    <div class="col-sm-10">
        {!! Form::select('province', Config::get('rentals.provinces'), null, ['id' => 'province', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="type" class="col-sm-2 control-label">Type</label>
    <div class="col-sm-10">
        {!! Form::select('type', Config::get('rentals.type'), null, ['class' => 'form-control']) !!}
    </diV>
</div>
<div class="form-group">
    <label for="beds" class="col-sm-2 control-label">Beds</label>
    <div class="col-sm-10">
        {!! Form::text('beds', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="baths" class="col-sm-2 control-label">Bathrooms</label>
    <div class="col-sm-10">
        {!! Form::text('baths', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="price" class="col-sm-2 control-label">Monthly Rent</label>
    <div class="col-sm-10">
        {!! Form::text('price', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="lease" class="col-sm-2 control-label">Lease (months)</label>
    <div class="col-sm-10">
        {!! Form::text('lease', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="deposit" class="col-sm-2 control-label">Deposit</label>
    <div class="col-sm-10">
        {!! Form::text('deposit', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="laundry" class="col-sm-2 control-label">Laundry</label>
    <div class="col-sm-10">
        {!! Form::select('laundry', Config::get('rentals.laundry'), null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="pets" class="col-sm-2 control-label">Pets</label>
    <div class="col-sm-10">
        {!! Form::select('pets', Config::get('rentals.pets'), null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="parking" class="col-sm-2 control-label">Parking</label>
    <div class="col-sm-10">
        {!! Form::select('parking', Config::get('rentals.parking'), null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="disability_access" class="col-sm-2 control-label">Disability Access</label>
    <div class="col-sm-10">
        {!! Form::radio('disability_access', 1) !!} Yes {!! Form::radio('disability_access', 0) !!} No
    </div>
</div>
<div class="form-group">
    <label for="smoking" class="col-sm-2 control-label">Smoking</label>
    <div class="col-sm-10">
        {!! Form::radio('smoking', 1) !!} Yes {!! Form::radio('smoking', 0) !!} No
    </div>
</div>
<div class="form-group">
    <label for="utilities_included" class="col-sm-2 control-label">Utilities Included</label>
    <div class="col-sm-10">
        {!! Form::radio('utilities_included', 1) !!} Yes {!! Form::radio('utilities_included', 0) !!} No
    </div>
</div>
<div class="form-group">
    <label for="heat_included" class="col-sm-2 control-label">Heat Included</label>
    <div class="col-sm-10">
        {!! Form::radio('heat_included', 1) !!} Yes {!! Form::radio('heat_included', 0) !!} No
    </div>
</div>
<div class="form-group">
    <label for="furnished" class="col-sm-2 control-label">Furnished</label>
    <div class="col-sm-10">
        {!! Form::radio('furnished', 1) !!} Yes {!! Form::radio('furnished', 0) !!} No
    </div>
</div>
<div class="form-group">
    <label for="square_footage" class="col-sm-2 control-label">Square Footage</label>
    <div class="col-sm-10">
        {!! Form::text('square_footage', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="available" class="col-sm-2 control-label">Date Available</label>
    <div class="col-sm-10">
        {!! Form::text('available', null, ['id' => 'available', 'class' => 'form-control', 'readonly']) !!}
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="features" class="col-sm-2 control-label">Features</label>
    <div class="col-sm-10">
        {!! Form::select('feature_list[]', \RentGorilla\Feature::lists('name', 'id'), null, ['id' => 'features', 'class' => 'form-control', 'multiple']) !!}
    </div>
</div>
<div class="form-group">
    <label for="features" class="col-sm-2 control-label">Appliances</label>
    <div class="col-sm-10">
        {!! Form::select('appliance_list[]', \RentGorilla\Appliance::lists('name', 'id'), null, ['id' => 'appliances', 'class' => 'form-control', 'multiple']) !!}
    </div>
</div>
<div class="form-group">
    <label for="features" class="col-sm-2 control-label">Heating</label>
    <div class="col-sm-10">
        {!! Form::select('heat_list[]', \RentGorilla\Heat::lists('name', 'id'), null, ['id' => 'heats', 'class' => 'form-control', 'multiple']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary btn-lg']) !!}
    <a href="{{ route('rental.index') }}" class="btn btn-primary btn-lg">Cancel</a>
    </div>
</div>


@section('footer')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script language="javascript">

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

            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
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

                    rentalForm.unbind('submit');
                    rentalForm.trigger('submit');

                } else {
                    showModal('We were unable to find that address. Please check your address.');
                    return false;
                }
            });

        });

    </script>
@stop
