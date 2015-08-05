@extends('layouts.admin')

@section('head')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <link rel="stylesheet" href="/css/form.css">
@stop

@section('content')
    <section class="content full admin">

        <h1>Subscribe to a Plan: {{ $plan->planName() }}</h1>
        <ul>
            <li>This plan allows you to have <strong>{{ $plan->maximumListings() }}</strong> active listings.</li>
            <li>You will be automatically billed <strong>{{ $plan->getPriceWithTax() }}</strong> (15% tax included)  every <strong>{{ $plan->interval() }}</strong>.</li>
            <li>Please note that you may change plans or cancel at any time.</li>
            <li>If you have a coupon, please enter it in the box below.</li>
        </ul>
        <br>
            {!! Form::open(['route' => ['subscribe', $plan->id()], 'id' => 'cc-form']) !!}

            <div class="form-group row">
                <label for="coupon_code">Have a Coupon?</label>

                <div class="col-md-3">
                    <input type="text" id="coupon_code" name="coupon_code" placeholder="" class="">
                </div>
            </div>
            @if( ! Auth::user()->readyForBilling())
                @include('partials.credit-card',  ['submitButtonText' => 'Start Subscription'])
            @endif
            {!! Form::close() !!}
    </section>
@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop