
@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/pricing.css?v=1">
@stop
@section('content')
    <section class="content full admin pricing">
        @if(Auth::user()->isOnFreePlan())
            <div class="toast">
                <span class="fa fa-close"></span>
                <h1><i class="fa fa-info-circle"></i> Free Plan</h1>
                <p>
                    <strong>Lucky you! You're on a Free Plan with RentGorilla.</strong><br/>
                    During your free plan period ({{  Auth::user()->getFreePlanExpiryDate()->diffInDays() }} days remaining) you can list a property on us!
                    <br/>
                </p>
                <p>
                    Thanks for listing with RentGorilla!
                </p>
            </div>
        @endif
        @if(Auth::user()->onTrial())
            <div class="toast">
                <span class="fa fa-close"></span>
                <h1><i class="fa fa-info-circle"></i> Free Trial</h1>
                <p>
                    <strong>Lucky you! You're on a Free Trial with RentGorilla.</strong><br/>
                    During your trial period ({{  Auth::user()->getTrialEndDate()->diffInDays() }} days remaining) you can list an unlimited number of properties with us.
                    <br/>
                    However, once your trial ends, you may still be eligible for the Free Plan.
                </p>
                <p>Please note that when you purchase a subscription that subscription will begin immediately and your free trial period will end.</p>
                <p>
                    Thanks for listing with RentGorilla!
                </p>
            </div>
        @endif
        @if(Auth::user()->cancelled() && Auth::user()->onGracePeriod())
            <div class="toast">
                <span class="fa fa-close"></span>
                <h1><i class="fa fa-info-circle"></i> Cancelled Subscription</h1>
                <p>
                    <strong>You have cancelled your plan {{ $plan->planName() }}</strong><br/>
                    You still can list up to {{ $plan->maximumListings() }} {{ str_plural('property', $plan->maximumListings()) }} with us until {{ Auth::user()->getCurrentPeriodEnd()->format('F jS, Y') }} ({{ $days = Auth::user()->subscription_ends_at->diffInDays() }} {{ str_plural('day', $days) }} from now).
                    <br/>
                </p>
                <p>Note that you can resume this subscription free of charge during this period.
                <p>
                    Thanks for listing with RentGorilla!
                </p>
            </div>
            <br>
        @endif
        @if(Auth::user()->stripeIsActive())
            <div class="toast">
                <span class="fa fa-close"></span>
                <h1><i class="fa fa-check-circle-o"></i> Subscribed to {{ $plan->planName() }}</h1>
                <p>
                    <strong>Yay! You have an active subscription!</strong><br/>
                    You can list up to {{ $plan->maximumListings() }} {{ str_plural('property', $plan->maximumListings()) }} with us.
                    <br/>
                </p>
                <p>
                    Thanks for listing with RentGorilla!
                </p>
            </div>
            <br>
        @endif
        <h1>RentGorilla Subscriptions</h1>
        <p>With RentGorilla, you can activate as many properties as your subscription plan allows. When you subscribe to a plan, your credit card will be automatically billed on a monthly basis. You may change plans or cancel at any time.</p>
        <br>
        @if(! Auth::user()->stripeIsActive())

            {!! Form::open() !!}
                <fieldset>
                    <legend>Start a New Subscription</legend>
                    <label class="required half right">Choose a plan:
                        {!! Form::select('plan_id', $plans, $plan ? $plan->id() : null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                    </label>
                    {!! Form::submit('Select', ['name' => 'subscribe', 'class' => 'button']) !!}
                </fieldset>
            {!! Form::close() !!}
            <br>
        @endif

        @if(Auth::user()->stripeIsActive())
            {!! Form::open() !!}
                <fieldset>
                    <legend>Swap to a Different Plan</legend>
                    <label class="required half right">Select a new plan:
                        {!! Form::select('plan_id', $plans, $plan ? $plan->id() : null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                    </label>
                    {!! Form::submit('Swap', ['name' => 'swap', 'class' => 'button']) !!}
                    <p>Please note: you may swap to a different plan without first cancelling your current plan.</p>
                </fieldset>
            {!! Form::close() !!}
            <br>
        @endif

        @if(Auth::user()->stripeIsActive())
            {!! Form::open() !!}
                <fieldset>
                    <legend>Cancel Your Subscription</legend>
                    <label class="required half right">Current plan:
                        <strong>{{ $plan->planName() }}</strong>
                    </label>
                    {!! Form::submit('Cancel', ['name' => 'cancel', 'class' => 'button']) !!}
                </fieldset>
            {!! Form::close() !!}
            <br>
        @endif

        @if(Auth::user()->cancelled() && Auth::user()->onGracePeriod() && ! $plan->isLegacy())
            {!! Form::open() !!}
                <fieldset>
                    <legend>Resume Your Subscription</legend>
                    <label class="required half right">Current plan:
                        <strong>{{ $plan->planName() }}</strong>
                    </label>
                    {!! Form::submit('Resume', ['name' => 'resume', 'class' => 'button']) !!}
                </fieldset>
            {!! Form::close() !!}
            <br>
        @endif

        <br>
        <br>

        @include('settings.partials.faq')
    </section>

    @include('settings.partials.achievements')

@endsection