<div class="form-group row">
    <label class="col-md-3 control-label" for="stripe_plan">Subscription Plan:</label>
    <div class="col-md-8">
    {!!   Form::select('stripe_plan', \RentGorilla\Plans\Subscription::fetchPlansForSelect(), isset($stripe_plan) ? $stripe_plan : null, ['class' => 'form-control']) !!}
    </div>
</div>
