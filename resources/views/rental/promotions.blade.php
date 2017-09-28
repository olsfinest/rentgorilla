@extends('layouts.admin')

@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('content')
<section class="content full admin">

    <h2>Please Confirm Your Order</h2>

    <h1>1. Promote {{ $rental->street_address  }}</h1>
    <br>

    @if( ! $rental->isActive())
        <p>You must activate your rental in order to promote it.</p>
    @else

        <p><strong>About Property Promotions</strong></p>

        <p>Property promotions cost <strong>${{ $price }}</strong> (tax included) for <strong>{{ config('promotion.days') }} days</strong>. A promoted property will be at the top of the search results for that city. Also, only <strong>{{ config('promotion.max') }}</strong> promotions are allowed for any city at any given time, ensuring your property will be seen.</p>

        @if($queued)
            <p><strong>Please Note:</strong></p>
            <p>There are already {{ config('promotion.max') }} promotions running for <strong>{{ $rental->location->city }}</strong>, however you may be put on the waiting list for a promotion slot, and your property will approximately be promoted on <strong>{{ $queued['dateAvailable']->format('F jS, Y') }}, ({{ $queued['daysRemaining'] }} days from now)</strong></p>
            <p>If paying by credit card, you will only be charged when the promotion starts. You may also cancel at any time before the promotion is scheduled to begin.</p>
        @endif

    <br><hr><br>
    <h1>2. Payment</h1>
        <div class="payment-errors alert alert-danger" style="display: none"></div>

        @include('errors.error-list')

        @if( ! Auth::user()->readyForBilling())
            {!! Form::open(['route' => 'rental.promote', 'class' => 'form', 'id' => 'cc-form']) !!}
        @else
            {!! Form::open(['route' => 'rental.promote', 'class' => 'form']) !!}
        @endif
            {!! Form::hidden('rental_id', $rental->uuid) !!}
        @if( ! Auth::user()->readyForBilling())
            @include('partials.credit-card', [ 'submitButtonText' => $queued ? 'Charge my Credit Card $' . $price . ' When My Promotion Starts' : 'Charge my Credit Card $' . $price])
        @else
            <p>Use existing Credit Card (ending in {{ Auth::user()->last_four }}) <a href="/admin/subscription/update">Use another card</a> </p>
            <button type="submit" class="button"> {{ $queued ? 'Charge my Credit Card $' . $price . ' When My Promotion Starts' : 'Charge my Credit Card $' . $price  }}</button>
        @endif
            {!! Form::close() !!}
        <br>
        <hr>
        <br>
        <p><strong>Pay With Points - New!</strong></p>
        <p>We now offer the option to pay for property promotions by redeeming <strong>{{ config('promotion.points') }} points</strong>.</p>
        <p>You currently have <strong>{{ Auth::user()->points }} points</strong>.</p>
        @if(Auth::user()->points >= config('promotion.points'))
            {!! Form::open(['route'=> ['rental.promote.points', $rental->uuid]]) !!}
            {!! Form::button('Redeem ' . config('promotion.points') . ' Points', ['type' => 'submit', 'class' => 'button']) !!}
            {!! Form::close() !!}
        @else
            <p>You only need <strong>{{ config('promotion.points') - Auth::user()->points }}</strong> more points in order to pay with points.</p>
        @endif
    @endif
</section>
@stop

@section('footer')
    <script src="/js/billing.js?v=1"></script>
@stop