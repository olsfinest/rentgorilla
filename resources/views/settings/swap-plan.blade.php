@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Swap Plan</h1>
        <p>You are currently subscribed to the <strong>{{ $plan->planName() }}</strong> plan until {{ Auth::user()->getCurrentPeriodEnd()->format('F jS, Y') }}.</p>
        <p>Would you like to swap it for the <strong>{{ $newPlan->planName() }}</strong> plan?</p>

        <h1>Plan comparison</h1>
        <table>
            <thead>
                <tr>
                    <th>Plan Name</th><th>Maximum Listings</th><th>Billing Period</th><th>Monthly Cost</th><th>Yearly Cost</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>{{ $plan->planName() }} [current plan]</td><td>{{ $plan->maximumListings() }}</td><td>{{ $plan->interval() }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($plan->monthlyBilledPrice(), true)  }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($plan->totalYearlyCost(), true) }}</td></tr>
                <tr><td>{{ $newPlan->planName() }}</td><td>{{ $newPlan->maximumListings() }}</td><td>{{ $newPlan->interval() }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($plan->monthlyBilledPrice(), true)  }}</td><td>{{ \RentGorilla\Plans\Plan::toDollars($newPlan->totalYearlyCost(), true) }}</td></tr>
            </tbody>
        </table>

        @if($isDowngrade)
            <p>Please note any active listings that exceed your new plan's capacity will be deactivated based on the date you last edited the listing(s).</p>
        @endif
        <p>
            {!! Form::open(['route' => ['subscription.swapSubscription', $newPlan->id()]]) !!}
            {!! Form::submit('Swap Plan to ' . $newPlan->planName()) !!}
            {!! Form::close() !!}
        </p>
    </section>
@stop