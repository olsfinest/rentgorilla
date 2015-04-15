@extends('layouts.main')

@section('header')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('header-text')
<h2 class="jumbotron__heading">Update Your Credit Card</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">

            @if(Auth::user()->readyForBilling())
<p class="breather">Want to update the credit card that we have on file? Provide the new details here. Don't worry; your card information will never touch our servers.</p>

            <div class="payment-errors alert alert-danger" style="display: none"></div>
            @include('errors.error-list')
            {!! Form::open(['route' => 'subscription.updateCard', 'id' => 'cc-form']) !!}

        @include('partials.credit-card', ['submitButtonText' => 'Update Credit Card'])


        {!! Form::close() !!}
                @else
            <p>No credit card on file.</p>
                @endif

        </div>
    </div>
</div>
@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop