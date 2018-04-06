    <span class="requiredNote"><strong>*</strong> Indicates Required Field</span>
    <fieldset>
        <legend>
            <i class="fa fa-map"></i> Location Information
        </legend>
        <label for="available" class="required">
            Date Available
            {!! Form::text('available', null, ['id' => 'available', 'class' => 'form-control', 'readonly', 'placeholder' => 'MM/DD/YYYY']) !!}
        </label>
        <label for="street_address" class="required half left">Street Address <i title="Feel free to use street abbreviations and specify apartment or unit numbers." class="fa fa-info-circle"></i>
             {!! Form::text('street_address', null, ['class' => 'form-control', 'id' => 'street_address', 'placeholder' => 'E.g., 123 Main Street']) !!}
        </label>
        <label for="city" class="required half right">City
            {!! Form::text('city', $rental->cityOnly, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'E.g., Antigonish']) !!}
        </label>
        <label for="province" class="required half left">Province
            {!! Form::select('province', Config::get('rentals.provinces'), null, ['autocomplete' => 'off', 'id' => 'province', 'class' => 'form-control']) !!}
        </label>
        <label for="postal_code" class="half right">Postal Code
            {!! Form::text('postal_code', $rental->postal_code, ['id' => 'postal_code', 'class' => 'form-control', 'placeholder' => 'E.g., B2G 2L2']) !!}
        </label>
    </fieldset>
    <fieldset>
        <legend><i class="fa fa-list-alt"></i> Property Details</legend>
        <label for="type" class="required half left">Type
            {!! Form::select('type', Config::get('rentals.type'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="beds" class="required half right">Bedrooms
            {!! Form::text('beds', null, ['class' => 'form-control', 'placeholder' => 'E.g., 4']) !!}
        </label>
        <label for="baths" class="required half left">Bathrooms <i class="fa fa-info-circle" title="Indicating a half bathroom means a sink and a toilet but no bath or shower"></i>
            {!! Form::text('baths', null, ['class' => 'form-control', 'placeholder' => 'E.g., 2.5']) !!}
        </label>
        <label for="price" class="required half right">Monthly Rent <i class="fa fa-info-circle" title="This value should reflect the total unit cost. Please note in your description if the price is per room."></i>
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'E.g., 500']) !!}
        </label>
        <label for="lease" class="required half left">Lease (months)
            {!! Form::text('lease', null, ['class' => 'form-control', 'placeholder' => 'E.g., 12']) !!}
        </label>
        <label for="deposit" class="required half right">Deposit
            {!! Form::text('deposit', null, ['class' => 'form-control', 'placeholder' => 'E.g., 300']) !!}
        </label>
        <label for="laundry" class="required half left">Laundry
            {!! Form::select('laundry', Config::get('rentals.laundry'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="pets" class="required half right">Pets
            {!! Form::select('pets', Config::get('rentals.pets'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="parking" class="half left">Parking
            {!! Form::select('parking', Config::get('rentals.parking'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="disability_access" class="required half right">Disability Access
            <span class="labelSpan">
            {!! Form::radio('disability_access', 1) !!} Yes {!! Form::radio('disability_access', 0) !!} No
            </span>
        </label>
        <label for="smoking" class="required half left">Smoking
            <span class="labelSpan">
            {!! Form::radio('smoking', 1) !!} Yes {!! Form::radio('smoking', 0) !!} No
            </span>
        </label>
        <label for="utilities_included" class="required half right">Utilities Included
            <span class="labelSpan">
            {!! Form::radio('utilities_included', 1) !!} Yes {!! Form::radio('utilities_included', 0) !!} No
            </span>
        </label>
        <label for="furnished" class="required half left">Furnished
        <span class="labelSpan">
        {!! Form::radio('furnished', 1) !!} Yes {!! Form::radio('furnished', 0) !!} No
        </span>
    </label>
    <label for="square_footage" class="half right">Square Footage
        {!! Form::text('square_footage', null, ['class' => 'form-control', 'placeholder' => 'E.g., 1000']) !!}
    </label>
    <label for="features" class="">Features</label>
     <table>
        @foreach(array_chunk(\RentGorilla\Feature::orderBy('name')->get()->all(), 2) as $column)
            <tr>
                @foreach($column as $feature)
                    <td><input type="checkbox" name="feature_list[]" value="{{ $feature->id }}"
                                {{ in_array($feature->id, $rental->features->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($feature->name) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
    <br>
    <label for="appliances" class="">Appliances</label>
    <table>
        @foreach(array_chunk(\RentGorilla\Appliance::orderBy('name')->get()->all(), 2) as $column)
            <tr>
                @foreach($column as $appliance)
                    <td><input type="checkbox" name="appliance_list[]" value="{{ $appliance->id }}"
                                {{ in_array($appliance->id, $rental->appliances->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($appliance->name) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
    </fieldset>
    <fieldset>
        <legend><i class="fa fa-fire"></i> Heating</legend>
        <label for="heat_included" class="required">Heat Included
            <span class="labelSpan">
            {!! Form::radio('heat_included', 1) !!} Yes {!! Form::radio('heat_included', 0) !!} No
            </span>
        </label>
        <label for="heats" class="">Heating</label>
        <table>
            @foreach(array_chunk(\RentGorilla\Heat::orderBy('name')->get()->all(), 2) as $column)
                <tr>
                    @foreach($column as $heat)
                        <td><input type="checkbox" name="heat_list[]" value="{{ $heat->id }}"
                                    {{ in_array($heat->id, $rental->heat->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($heat->name) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </fieldset>
    <fieldset>
        <legend><i class="fa fa-question-circle"></i> Vitals</legend>
        <label for="video" class="">Link to video
            {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=764xqeDO3yk']) !!}
        </label>
        <label for="description" class="">Description
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'A brief description of the property...']) !!}
        </label>
    </fieldset>
    <label for="active" class="">Activate Rental
      {!! Form::checkbox('active', 1, null, ['id' => 'active']) !!}
    </label>
    {!! Form::submit($submitButtonText) !!}
@section('footer')
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/modify-rental.js?v=1"></script>
@endsection
