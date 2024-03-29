@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h2>Please Confirm Your Order</h2>
        <h1>1. Swap Plans</h1>
        @if(Auth::user()->stripeIsActive())
            <p>You are currently subscribed to the <strong>{{ $plan->planName() }}</strong> plan until {{ Auth::user()->getCurrentPeriodEnd()->format('F jS, Y') }}.</p>
            <p>Would you like to swap it for the <strong>{{ $newPlan->planName() }}</strong> plan?</p>
            <br><hr><br>
            <h1>2. Plan comparison</h1>
            <table>
                <thead>
                    <tr>
                        <th>Plan Name</th><th>Maximum Listings</th><th>Billing Period</th><th>Monthly Cost *</th><th>Yearly Cost *</th><th>15% tax incl.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>{{ $plan->planName() }} [current plan]</td><td>{{ $plan->maximumListings() }}</td><td>{{ $plan->intervalSuffix() }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($plan->monthlyBilledPrice(), true)  }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($plan->totalYearlyCost(), true) }}</td><td>{{ $plan->getPriceWithTax(false, true) }}</td></tr>
                    <tr><td>{{ $newPlan->planName() }}</td><td>{{ $newPlan->maximumListings() }}</td><td>{{ $newPlan->intervalSuffix() }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($newPlan->monthlyBilledPrice(), true)  }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($newPlan->totalYearlyCost(), true) }}</td><td>{{ $newPlan->getPriceWithTax(false, true) }}</td></tr>
                </tbody>
            </table>
            <p>* price does not include 15% tax</p>
        <br><hr><br>
            <h1>3. Payment</h1>
            <p>Use existing Credit Card (ending in {{ Auth::user()->last_four }}) <a href="/admin/subscription/update">Use another card</a> </p>
            @if($isDowngrade)
                <p>Please note any active listings that exceed your new plan's capacity will be deactivated based on the date you last edited the listing(s).</p>
            @endif
            <p>
                @include('errors.error-list')

                {!! Form::open(['route' => ['subscription.swapSubscription', $newPlan->id()]]) !!}
                <button type="submit" class="button">{{ 'Swap Plan to ' . $newPlan->planName() . ' - Pay Now' }}</button>
                {!! Form::close() !!}
            </p>
        @else
            <p>Sorry, you must have an active subscription to swap plans.</p>
        @endif
    </section>
@stop