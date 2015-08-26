@extends('emails.layouts.default')

@section('body')
    <p>The promotion for your property <strong>{{ $address }}</strong> was not able to begin as intended because we attempted to charge your credit card and it failed.</p>
    <p>If you still wish to promote your property, please update your credit card information and try again.</p>
    @include('emails.user.partials.button', ['route' => route('updateCard'), 'title' => 'Update Credit Card'])

@stop