@extends('emails.layouts.default')

@section('body')
    <p>Your subscription to <strong>{{ $planName }}</strong> has resumed.</p>
    <p>Under this plan, you may have <strong>{{ $maxListings }}</strong> active listings at any given time.</p>
    <p>Your credit card will automatically be billed every <strong>{{ $interval }}</strong>.</p>
    <p>Of course you may change to a different plan or cancel at any time.</p>
@stop