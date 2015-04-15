@extends('layouts.main')

@section('header')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop


@section('header-text')
<h2 class="jumbotron__heading">Your Subscription Plan</h2>
<h3>Current Plan:
    @if(Auth::user()->subscribed())
        @if(Auth::user()->getStripePlan())
                {{ \RentGorilla\Plans\Subscription::plan(Auth::user()->getStripePlan())->planName() }}
        @else
            Trial
        @endif
    @else
    Not Subscribed
    @endif
</h3>
@if(Auth::user()->getSubscriptionEndDate())
    <h3>Expires: {{  Auth::user()->getSubscriptionEndDate()->format('F jS, Y') }} ({{ Auth::user()->getSubscriptionEndDate()->diffForHumans() }})</h3>
@endif
@if(Auth::user()->getTrialEndDate())
    <h3>Trial expires: {{  Auth::user()->getTrialEndDate()->format('F jS, Y') }} ({{ Auth::user()->getTrialEndDate()->diffForHumans() }})</h3>
@endif
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">

            <h3>Available Subscription Plans</h3>

            @include('partials.plans-table')

            <div class="payment-errors alert alert-danger" style="display: none"></div>

            @include('errors.error-list')

            @if(Auth::user()->stripeIsActive())

                <h3>Change your Subscription Plan</h3>

            <hr>

                {!! Form::open(['route' => 'subscription.changePlan']) !!}

                @include('partials.subscription-plans', ['stripe_plan' => Auth::user()->getStripePlan()])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Change Plan">
                </div>
                {!! Form::close() !!}

            @else

                <h3>Start a Subscription Plan</h3>

                <hr>

                @if( ! Auth::user()->readyForBilling())

                    {!! Form::open(['route' => 'subscribe', 'id' => 'cc-form']) !!}

                    @include('partials.subscription-plans', ['stripe_plan' => Auth::user()->getStripePlan()])

                    <div class="form-group row">
                        <label for="cvv" class="col-md-3 control-label" for="coupon_code">Have a Coupon?</label>

                        <div class="col-md-3">
                            <input type="text" id="coupon_code" name="coupon_code" placeholder="" class="form-control">
                        </div>
                    </div>

                    @include('partials.credit-card',  ['submitButtonText' => 'Start Subscription'])
                    {!! Form::close() !!}
                @else

                    {!! Form::open(['route' => 'subscription.changePlan']) !!}

                    @include('partials.subscription-plans', ['stripe_plan' => Auth::user()->getStripePlan()])

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Start Subscription">
                    </div>
                    {!! Form::close() !!}
                @endif
            @endif
        </div>
    </div>
</div>
@stop

@section('footer')
<script src="/js/billing.js"></script>
@stop