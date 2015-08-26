@extends('emails.layouts.default')

@section('body')
    <p>Welcome to RentGorilla.ca!</p>
    <p>Please click the link below to enter your new password and take control of your account.</p>
    <p>We're happy to have you aboard!</p>


    @include('emails.user.partials.button', ['route' => url('password/reset/'.$token), 'title' => 'Set New Password'])

@stop