@extends('emails.layouts.default')

@section('body')
    <p>Thank you for promoting your property <strong>{{ $address }}</strong>.</p>
    <p>Your promotion will start on <strong>{{ $date }}</strong> and last for {{ Config::get('promotion.days') }} days.</p>
@stop