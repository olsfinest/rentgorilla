@extends('emails.layouts.default')

@section('body')
    <p>Your subscription to <strong>{{ $planName }}</strong> has been changed.</p>
    <p>Under this plan, you may have <strong>{{ $maxListings }}</strong> active listings at any given time.</p>
    @if($interval)
        <p>Your credit card will automatically be billed every <strong>{{ $interval }}</strong>.</p>
    @endif
    <p>Of course you may change to a different plan or cancel at any time.</p>
    @if($isDownGrade)
        <p>Please note any previous active listings that exceeded your new plan's capacity have been deactivated based on the date you last edited the listing(s).</p>
    @endif
@stop