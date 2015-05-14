@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>Your subscription to {{ $planName }} has been cancelled.</p>
        <p>You may continue to use this plan until {{ $subscriptionEndsAt }} ({{ $daysFromNow }}).</p>
        <p>Thanks for using our service.</p>
        <p>- The RentGorilla.ca Team</p>
    </div>

@stop