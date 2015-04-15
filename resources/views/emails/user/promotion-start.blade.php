@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>The promotion for your property <strong>{{ $address }}</strong> has begun!</p>
        <p>Your promotion will last for {{ Config::get('promotion.days') }} days.</p>
        <p>Thank you for choosing RentGorilla.ca!</p>
    </div>

@stop