@extends('emails.layouts.default')

@section('body')
    <p>We attempted to charge your credit card for your normal subscription, however the charge failed.</p>
    <p>We have cancelled your subscription, however you may update your credit card details and resubscribe at any time.</p>

    @include('emails.user.partials.button', ['route' => route('updateCard'), 'title' => 'Update Card'])

@stop