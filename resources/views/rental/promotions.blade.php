@extends('layouts.admin')

@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('content')
    <section class="content full admin">

    <h1>Promote {{ $rental->street_address  }}</h1>

    @if( ! $rental->isActive())
        <p>You must activate your rental in order to promote it.</p>
    @else

    <p><strong>About Property Promotions</strong></p>

    <p>Property promotions cost ${{ $price }} (tax included) for seven days. A promoted property will be at the top of the search results for that city. Also, only three promotions are allowed for any city at any given time, ensuring your property will be seen.</p>

    @if($queued)
        <p><strong>Please Note:</strong></p>
        <p>There are already three promotions running for <strong>{{ $rental->location->city }}</strong>, however you may be put on the waiting list for a promotion slot, and your property will approximately be promoted on <strong>{{ $queued['dateAvailable']->format('F jS, Y') }}, ({{ $queued['daysRemaining'] }} days from now)</strong></p>
        <p>Your credit card will only be charged when the promotion starts. You may also cancel at any time before the promotion is scheduled to begin.</p>
    @endif

        <div class="payment-errors alert alert-danger" style="display: none"></div>

        @include('errors.error-list')

        @if( ! Auth::user()->readyForBilling())
            {!! Form::open(['route' => 'rental.promote', 'class' => 'form', 'id' => 'cc-form']) !!}
        @else
            {!! Form::open(['route' => 'rental.promote', 'class' => 'form']) !!}
        @endif
            {!! Form::hidden('rental_id', $rental->uuid) !!}
        @if( ! Auth::user()->readyForBilling())
            @include('partials.credit-card', [ 'submitButtonText' => $queued ? 'Charge my Credit Card $' . $price . ' When My Promotion Starts' : 'Charge my Credit Card ' . $price])
        @else
            <button type="submit" class=""> {{ $queued ? 'Charge my Credit Card $' . $price . ' When My Promotion Starts' : 'Charge my Credit Card ' . $price  }}</button>
        @endif
            {!! Form::close() !!}
        @endif
    </section>

@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop


