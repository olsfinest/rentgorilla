@extends('layouts.admin')

@section('head')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop

@section('content')
    <section class="content full admin">
        <h1>Adjust Billing To Credit Card</h1>
        <p>To change a plan or cease billing please edit your <a href="{{ route('changePlan') }}">Subscription</a></p>
        <br>
        <h1>Current Credit Card On File</h1>
        @if(Auth::user()->readyForBilling() && ! is_null(Auth::user()->last_four))
            <p>**** **** **** {{ Auth::user()->last_four }}</p>
        @else
            <p>You have no credit card on file.</p><br/>
            <p class="billing-note">Visit our <a href="{{ route('changePlan') }}">Subscription</a> page, choose the plan to fit your needs and you will be prompted for a credit card after you select your subscription.</p>
        @endif

        @if(Auth::user()->readyForBilling())
            <h1>Update Credit Card on File</h1>
            <p>Provide your new new details below. We accept American Express, Mastercard, Visa.</p>

            @include('errors.credit-card-errors')
            @include('errors.error-list')

            {!! Form::open(['route' => 'subscription.updateCard', 'id' => 'cc-form']) !!}

            @include('partials.credit-card', ['submitButtonText' => 'Update Credit Card'])

            {!! Form::close() !!}
        @endif

    </section>
@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop