@extends('emails.layouts.default')

@section('body')
    <p>Your subscription to {{ $planName }} has been cancelled.</p>
    <p>You may continue to use this plan until {{ $subscriptionEndsAt }} ({{ $daysFromNow }}).</p>
@stop