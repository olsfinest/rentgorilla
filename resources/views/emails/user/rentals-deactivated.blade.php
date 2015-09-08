@extends('emails.layouts.default')

@section('body')

    <p>Unfortunately your account has expired and your properties have been deactivated.</p>
    <p>Should you wish to start or resume your subscription, please click the button below:</p>
    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscription'])
@stop