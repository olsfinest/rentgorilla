@extends('emails.layouts.default')

@section('body')
    <p>Unfortunately your plan has expired and any properties have been deactivated.</p>
    <p>Should you wish to start or resume a subscription, please click the button below:</p>
    @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscription'])
@stop