@extends('emails.layouts.default')

@section('body')
    <p>Unfortunately your plan has expired.</p>
    <p>As you are still eligible for the free plan, your most recently edited plan remains active.</p>
    <p>Should you wish to begin or resume a subscription, please click here:

    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscriptions'])

@stop