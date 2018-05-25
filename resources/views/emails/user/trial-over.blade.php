@extends('emails.layouts.default')

@section('body')
    <p>This is a friendly reminder that your free trial period has ended.</p>
    <p>If you took advantage of the free listing, we have now deactivated a listing based on the date you last edited the listing(s).</p>
    <p>Remember, you can always choose which properties are currently active on your <a href="{{ route('rental.index') }}">Dashboard</a> when you have the plan capacity to do so.</p>
    @if($subscribed)
        <p>Thank you for being a subscribed member of RentGorilla.ca</p>
    @else
        <p>Should you wish to start or resume a subscription, please click the button below:</p>
        @include('emails.user.partials.button', ['route' => route('changePlan'), 'title' => 'Subscription'])
    @endif
@stop