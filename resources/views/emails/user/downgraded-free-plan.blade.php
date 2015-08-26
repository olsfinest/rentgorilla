@extends('emails.layouts.default')

@section('body')
    <p>Unfortunately your account has expired.</p>
    <p>As you are still eligible for the free plan, your most recently edited plan remains active.</p>
    <p>Should you wish to resume your subscription, please click here:

    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Resume Subscription'])

@stop