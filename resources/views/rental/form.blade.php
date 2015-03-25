<div class="form-group">
    <label for="street_address" class="col-sm-2 control-label">Street Address</label>
    <div class="col-sm-10">
        {!! Form::text('street_address', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="city" class="col-sm-2 control-label">City</label>
    <div class="col-sm-10">
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="province" class="col-sm-2 control-label">Province</label>
    <div class="col-sm-10">
        {!! Form::select('province', Config::get('rentals.provinces'), null, ['class' => 'form-control']) !!}
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
    <label for="price" class="col-sm-2 control-label">Monthly Rent</label>
    <div class="col-sm-10">
        {!! Form::text('price', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label for="available_at" class="col-sm-2 control-label">Date Available</label>
    <div class="col-sm-10">
        {!! Form::text('available_at', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary btn-lg']) !!}
    <a href="{{ route('rental.index') }}" class="btn btn-primary btn-lg">Cancel</a>
    </div>
</div>