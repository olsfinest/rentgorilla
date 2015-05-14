@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>The promotion for your property <strong>{{ $address }}</strong> was not able to begin as intended because your credit card charge failed.</p>
        <p>If you still wish to promote your property, please try again.</p>
        <p>Thank you for choosing RentGorilla.ca!</p>
    </div>

@stop