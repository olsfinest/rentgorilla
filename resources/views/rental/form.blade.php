    <span class="requiredNote"><strong>*</strong> Indicates Required Field</span>
	
	<fieldset>
        <legend>
            <i class="fa fa-map"></i> Timing
        </legend>
        <label for="available" class="required half left">
            Date Available
            {!! Form::text('available', null, ['id' => 'available', 'class' => 'form-control',  'placeholder' => 'MM/DD/YYYY']) !!}
        </label>

		<label for="lease" class="required half right">Lease (months)
            {!! Form::text('lease', null, ['class' => 'form-control', 'placeholder' => 'E.g., 12']) !!}
        </label>
		
		<label for="yearofconstruction" class="half left">Year of construction
            {!! Form::text('yearofconstruction', null, ['class' => 'form-control', 'placeholder' => 'E.g., 2019']) !!}
        </label>
		
		<label for="yearofrenovation" class="half right">Year of Recent Renovation
            {!! Form::text('yearofrenovation', null, ['class' => 'form-control', 'placeholder' => 'E.g., 2019']) !!}
        </label>
		
		
       
    </fieldset>
	
    <fieldset>
        <legend>
            <i class="fa fa-map"></i> Location Information
        </legend>
       
        <label for="street_address" class="required half left">Street Address <i title="Feel free to use street abbreviations and specify apartment or unit numbers." class="fa fa-info-circle"></i>
             {!! Form::text('street_address', null, ['class' => 'form-control', 'id' => 'street_address', 'placeholder' => 'E.g., 123 Main Street']) !!}
        </label>
		
		<label for="apartment/suite" class="half right">Apartment/Suite
            {!! Form::text('apartment', null, ['class' => 'form-control', 'placeholder' => 'E.g., Clary Apartment']) !!}
        </label>
		
		 <label for="city" class="required half left">City
            {!! Form::text('city', $rental->cityOnly, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'E.g., Antigonish']) !!}
        </label>
			
        <label for="province" class="required half right">Province
            {!! Form::select('province', Config::get('rentals.provinces'), null, ['autocomplete' => 'off', 'id' => 'province', 'class' => 'form-control']) !!}
        </label>
		

        <label for="postal_code" class="">Postal Code
            {!! Form::text('postal_code', $rental->postal_code, ['id' => 'postal_code', 'class' => 'form-control', 'placeholder' => 'E.g., B2G 2L2']) !!}
        </label>
    </fieldset>
    <fieldset>
        <legend><i class="fa fa-list-alt"></i> Property Details</legend>
		
		<label for="price" class="required half left">Monthly Rent
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'E.g., 500']) !!}
            Per Room? {!! Form::checkbox('per_room', 1, null) !!}
        </label>
		
        <label for="type" class="required half right">Type of Property
            {!! Form::select('type', Config::get('rentals.type'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
		
		<label for="floors" class="half left">Flooring
              {!! Form::select('floors', Config::get('rentals.type'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
		
	
		
        <label for="beds" class="required half right">Bedrooms
            {!! Form::text('beds', null, ['class' => 'form-control', 'placeholder' => 'E.g., 4']) !!}
        </label>
		
        <label for="baths" class="required half left">Bathrooms <i class="fa fa-info-circle" title="Indicating a half bathroom means a sink and a toilet but no bath or shower"></i>
            {!! Form::text('baths', null, ['class' => 'form-control', 'placeholder' => 'E.g., 2.5']) !!}
        </label>
       
    
        <label for="deposit" class="required half right">Deposit
            {!! Form::text('deposit', null, ['class' => 'form-control', 'placeholder' => 'E.g., 300']) !!}
        </label>
		
       
        <label for="pets" class="half left">Pets
            {!! Form::select('pets', Config::get('rentals.pets'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="parking" class="half right">Parking
            {!! Form::select('parking', Config::get('rentals.parking'), null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        </label>
        <label for="disability_access" class="half left">Accessibility Access
            <span class="labelSpan">
            {!! Form::radio('disability_access', 1) !!} Yes {!! Form::radio('disability_access', 0) !!} No
            </span>
        </label>
        <label for="smoking" class="half right">Smoking
            <span class="labelSpan">
            {!! Form::radio('smoking', 1) !!} Yes {!! Form::radio('smoking', 0) !!} No
            </span>
        </label>
		
		
         <label for="utitlies" class="half left">Utilities
        <table style="width:100%;">
            @foreach(array_chunk(\RentGorilla\Utility::orderBy('name')->get()->all(), 2) as $column)
                <tr>
                    @foreach($column as $utility)
                        <td><input type="checkbox" name="utility_list[]" value="{{ $utility->id }}"
                                    {{ in_array($utility->id, $rental->utility->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($utility->name) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
		</label>
		
       

	
	
	
    <label for="furnished" class="half right">Furnished
        <span class="labelSpan">
        {!! Form::radio('furnished', 0) !!} None {!! Form::radio('furnished', 1) !!} Partially {!! Form::radio('furnished', 3) !!} Fully
        </span>
    </label>
	
    <label for="square_footage" class="">Square Footage
        {!! Form::text('square_footage', null, ['class' => 'form-control', 'placeholder' => 'E.g., 1000']) !!}
    </label>
   
    <br>
   
    </fieldset>
	
	<fieldset>
	
        <legend><i class="fa fa-list-alt"></i> Safety and Security</legend>
		
		<table style="width:100%; ">
            @foreach(array_chunk(\RentGorilla\Safety::orderBy('name')->get()->all(), 2) as $column)
                <tr>
                    @foreach($column as $safety)
						<td><input type="checkbox" name="safety_list[]" value="{{ $safety->id }}"
					{{ in_array($safety->id, $rental->safeties->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($safety->name) }}</td>
					
                    @endforeach
                </tr>
            @endforeach
        </table>
		
		<br/>
		<label for="occupancy_permit" class="required half left">Occupancy Permit
            <span class="labelSpan">
            {!! Form::radio('occupancy_permit', 1) !!} Yes {!! Form::radio('occupancy_permit', 0) !!} No
            </span>
        </label>
		
		
		<label for="up_to_code" class="required half right">Up To Code
            <span class="labelSpan">
            {!! Form::radio('up_to_code', 1) !!} Yes {!! Form::radio('up_to_code', 0) !!} No
            </span>
        </label>
		
		
	</fieldset>	
	
	<fieldset>
	
        <legend><i class="fa fa-list-alt"></i> Features</legend>
		
		
		 <table style="width:100%;">
			@foreach(array_chunk(\RentGorilla\Feature::orderBy('name')->get()->all(), 2) as $column)
				<tr>
					@foreach($column as $feature)
						<td><input type="checkbox" name="feature_list[]" value="{{ $feature->id }}"
									{{ in_array($feature->id, $rental->features->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($feature->name) }}</td>
					@endforeach
				</tr>
			@endforeach
		</table>
		
		
	</fieldset>		
	
	
	
	<fieldset>
	
    <legend><i class="fa fa-list-alt"></i> Appliances</legend>
    <table style="width:100%;">
        @foreach(array_chunk(\RentGorilla\Appliance::orderBy('name')->get()->all(), 2) as $column)
            <tr>
                @foreach($column as $appliance)
                    <td><input type="checkbox" name="appliance_list[]" value="{{ $appliance->id }}"
                                {{ in_array($appliance->id, $rental->appliances->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($appliance->name) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
	<br/>
	<label for="laundry" class="">Laundry
            {!! Form::select('laundry', Config::get('rentals.laundry'), 'default', ['autocomplete' => 'off', 'class' => 'form-control']) !!}
    </label>
	
	</fieldset>	
	
	
	<fieldset>
	
    <legend><i class="fa fa-list-alt"></i> Services</legend>
    <table style="width:100%;">
        @foreach(array_chunk(\RentGorilla\Service::orderBy('name')->get()->all(), 2) as $column)
            <tr>
                @foreach($column as $service)
                    <td><input type="checkbox" name="appliance_list[]" value="{{ $appliance->id }}"
                                {{ in_array($service->id, $rental->appliances->pluck('id')->all()) ? 'checked' : '' }}> {{ ucwords($service->name) }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
	<br/>
	
	
	</fieldset>	
	
    <fieldset>
        <legend><i class="fa fa-fire"></i> Heating</legend>
		
		<!-- <label for="heat_included" class="half right">Heat Included
            <span class="labelSpan">
            {!! Form::radio('heat_included', 1) !!} Yes {!! Form::radio('heat_included', 0) !!} No
            </span>
		</label> -->
		

        <label for="heats" class="">Heating</label>
        <table style="width:100%;">
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
	


	
        <legend><i class="fa fa-question-circle"></i> Additional Information</legend>
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
	
		
    {!! Form::submit($submitButtonText , ['data-toggle' => 'modal' , 'data-target' => '#confirm-submit' , 'type' => 'submit' , 'class' => 'button']) !!}
@section('footer')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
   <script src="/js/modify-rental.js?v=1"></script>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    
    <!-- Modal HTML -->
    <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Activate/Publish Property Upon Saving This Listing <input id="active1" name="active" type="checkbox" value="1"><br/>
(Requires Active Property Capacity via Your <a target="blank" href="../admin/subscription/plan">Subscription</a>)</p>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-primary" id="submitmodal" style="float:left; font-size:12px;">Save Listing & Proceed To Add Photos To Property	</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float:right; font-size:12px;">Cancel & Return To Dashboard</button>  
                </div>
            </div>
        </div>
    </div>
	
	
	
	<script>
	
	jQuery(document).ready(function( $ ) {

	
	$('#submitmodal').click(function(){	
		$('#modify_rental_form').submit();
	});
	
	$(".button").prop("type", "button");
	
	var chk1 = $('#active1');
	var chk2 = $('#active');

	//check the other box
	chk1.on('click', function(){
	  if( chk1.is(':checked') ) {
		chk2.attr('checked', true);
	  } else {
		chk2.attr('checked', false);
	  }
	});
	
	
	
	});	
	
	</script>
