@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>Your subscription to <strong>{{ $planName }}</strong> has been resumed.</p>
        <p>Under this plan, you may have <strong>{{ $maxListings }}</strong> active listings at any given time.</p>
        <p>Your credit card will automatically be billed every <strong>{{ $interval }}</strong>.</p>
        <p>Of course you may change to a different plan or cancel at any time.</p>
        <p>Thanks for using our service.</p>
        <p>- The RentGorilla.ca Team</p>
    </div>

@stop