@extends('emails.layouts.default')

@section('body')
    <p>Unfortunately your plan has expired.</p>
    <p>As you are within a year of joining us, you are still eligible for the <strong>Free Plan</strong>.</p>
    <p>Please note that if you had active properties, your most recently edited property remains active.</p>
    <p>Should you wish to begin or resume a subscription to activate more properties, please click here:

    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscriptions'])

@stop