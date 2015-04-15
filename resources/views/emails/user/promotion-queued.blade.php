@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>Thank you for promoting your property <strong>{{ $address }}</strong>.</p>
        <p>Your promotion will start on <strong>{{ $date }}</strong> and last for {{ Config::get('promotion.days') }} days.</p>
        <p>Thank you for choosing RentGorilla.ca!</p>
    </div>

@stop