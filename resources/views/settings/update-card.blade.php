@extends('layouts.admin')

@section('head')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <link rel="stylesheet" href="/css/form.css">
@stop

@section('content')
    <section class="content full admin">
        <h1>Update Credit Card</h1>
            @if(Auth::user()->readyForBilling())
<p class="breather">Want to update the credit card that we have on file? Provide the new details here.</p>

            @include('errors.credit-card-errors')
            @include('errors.error-list')

            {!! Form::open(['route' => 'subscription.updateCard', 'id' => 'cc-form']) !!}

        @include('partials.credit-card', ['submitButtonText' => 'Update Credit Card'])


        {!! Form::close() !!}
                @else
            <p>You have no credit card on file.</p><br/>
			<p class="billing-note">Visit our <a href="plan">Subscription</a> page, choose the plan to fit your needs and you will be prompted for a credt card after you select your subscription.</p>
                @endif
</section>
@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop