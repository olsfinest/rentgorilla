    <label for="available" class="">Date Available
        {!! Form::text('available', null, ['id' => 'available', 'class' => 'form-control', 'readonly', 'placeholder' => 'MM/DD/YYYY']) !!}
    </label>
    <label for="street_address" class="">Street Address
         {!! Form::text('street_address', null, ['class' => 'form-control', 'id' => 'street_address', 'placeholder' => '123 Main Street']) !!}
    </label>
    <label for="city" class="">City
        {!! Form::text('city', $rental->cityOnly, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Antigonish']) !!}
    </label>
    <label for="province" class="">Province
        {!! Form::select('province', Config::get('rentals.provinces'), null, ['id' => 'province', 'class' => 'form-control']) !!}
    </label>
    <label for="postal_code" class="">Postal Code
        {!! Form::text('postal_code', $rental->postal_code, ['id' => 'postal_code', 'class' => 'form-control', 'placeholder' => 'B2G 2L2']) !!}
    </label>
    <label for="type" class="">Type
        {!! Form::select('type', Config::get('rentals.type'), null, ['class' => 'form-control']) !!}
    </label>
    <label for="beds" class="">Beds
        {!! Form::text('beds', null, ['class' => 'form-control', 'placeholder' => '4']) !!}
    </label>
    <label for="baths" class="">Bathrooms
        {!! Form::text('baths', null, ['class' => 'form-control', 'placeholder' => '2.5']) !!}
    </label>
    <label for="price" class="">Monthly Rent
        {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => '500']) !!}
    </label>
    <label for="lease" class="">Lease (months)
        {!! Form::text('lease', null, ['class' => 'form-control', 'placeholder' => '12']) !!}
    </label>
    <label for="deposit" class="">Deposit
        {!! Form::text('deposit', null, ['class' => 'form-control', 'placeholder' => '300']) !!}
    </label>
    <label for="laundry" class="">Laundry
        {!! Form::select('laundry', Config::get('rentals.laundry'), null, ['class' => 'form-control']) !!}
    </label>
    <label for="pets" class="">Pets
        {!! Form::select('pets', Config::get('rentals.pets'), null, ['class' => 'form-control']) !!}
    </label>
    <label for="parking" class="">Parking
        {!! Form::select('parking', Config::get('rentals.parking'), null, ['class' => 'form-control']) !!}
    </label>
    <label for="disability_access" class="">Disability Access
        <span>
        {!! Form::radio('disability_access', 1) !!} Yes {!! Form::radio('disability_access', 0) !!} No
        </span>
    </label>
    <label for="smoking" class="">Smoking
        <span>
        {!! Form::radio('smoking', 1) !!} Yes {!! Form::radio('smoking', 0) !!} No
        </span>
    </label>
    <label for="utilities_included" class="">Utilities Included
        <span>
        {!! Form::radio('utilities_included', 1) !!} Yes {!! Form::radio('utilities_included', 0) !!} No
        </span>
    </label>
    <label for="heat_included" class="">Heat Included
        <span>
        {!! Form::radio('heat_included', 1) !!} Yes {!! Form::radio('heat_included', 0) !!} No
        </span>
    </label>
    <label for="heats" class="">Heating</label>
        {!! Form::select('heat_list[]', \RentGorilla\Heat::orderBy('name')->lists('name', 'id')->all(), null, ['id' => 'heats', 'class' => 'form-control', 'multiple']) !!}
    <br>
    <br>
    <label for="furnished" class="">Furnished
        <span>
        {!! Form::radio('furnished', 1) !!} Yes {!! Form::radio('furnished', 0) !!} No
        </span>
    </label>
    <label for="square_footage" class="">Square Footage
        {!! Form::text('square_footage', null, ['class' => 'form-control', 'placeholder' => '1000']) !!}
    </label>
    <label for="video" class="">Link to video
        {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=764xqeDO3yk']) !!}
    </label>
    <label for="description" class="">Description
        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'A brief description of the property...']) !!}
    </label>
    <label for="features" class="">Features</label>
        {!! Form::select('feature_list[]', \RentGorilla\Feature::orderBy('name')->lists('name', 'id')->all(), null, ['id' => 'features', 'class' => 'form-control', 'multiple']) !!}

    <label for="appliances" class="">Appliances</label>
        {!! Form::select('appliance_list[]', \RentGorilla\Appliance::orderBy('name')->lists('name', 'id')->all(), null, ['id' => 'appliances', 'class' => 'form-control', 'multiple']) !!}
    <br>

    <label for="active" class="">Activate Rental</label>
        {!! Form::checkbox('active') !!}

    {!! Form::submit($submitButtonText) !!}



@section('footer')
    <script src="/js/select2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/modify-rental.js"></script>
@endsection
