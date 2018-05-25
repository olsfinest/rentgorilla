@extends('emails.layouts.default')

@section('body')
    <p>Unfortunately your plan has expired.</p>
    @if($isGrandfathered)
        <p>As you are within a year of joining us, you are still eligible for one active property on the <strong>Free Plan</strong>.</p>
    @else
        <p>As you are within {{ config('plans.freeForXDays') }} days of joining us, you are still eligible for one active property on the <strong>Free Plan</strong>.</p>
    @endif
    <p>Please note that if you had active properties, your most recently edited property remains active.</p>
    <p>Should you wish to begin or resume a subscription to activate more properties, please click here:</p>
    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscriptions'])
@stop