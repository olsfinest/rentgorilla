@extends('emails.layouts.default')

@section('body')
    <p>Thank you for your recent purchase from our website!</p>
    <p>The promotion for your property <strong>{{ $address }}</strong> has begun.</p>
    <p>Your promotion will last for {{ Config::get('promotion.days') }} days.</p>
    @include('emails.partials.tips')
@stop