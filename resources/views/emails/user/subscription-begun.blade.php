@extends('emails.layouts.default')

@section('body')
    <p>Thank you for your recent purchase from our website!</p>
    <p>Your subscription to <strong>{{ $planName }}</strong> has begun.</p>
    <p>Under this plan, you may have <strong>{{ $maxListings }}</strong> active {{ str_plural('listing', $maxListings) }} at any given time.</p>
    <p>Your credit card will automatically be billed every <strong>{{ $interval }}</strong>.</p>
    <p>Of course you may change to a different plan or cancel at any time.</p>
    @if($isDowngrade)
        <p>Please note any previous active listings that exceeded your new plan's capacity have been deactivated based on the date you last edited the listing(s).</p>
        <p>However, you can always choose which properties are currently active on your Dashboard.</p>
    @endif
    @include('emails.partials.tips')
@stop