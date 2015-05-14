@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>We would like to take this opportunity to welcome you to RentGorilla.ca!</p>
        <p>We hope that you discover it to be the easiest way to find and post rental properties.</p>
        <p>Please let us know if we may assist you in any way.</p>
        <p>Thanks,</p>
        <p>- The RentGorilla.ca Team</p>
    </div>

@stop