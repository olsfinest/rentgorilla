@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>The promotion for your property <strong>{{ $address }}</strong> has ended.</p>
        <p>Thank you for choosing RentGorilla.ca!</p>
    </div>

@stop