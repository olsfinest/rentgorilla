@extends('emails.layouts.default')

@section('body')
    <p>Welcome to RentGorilla.ca!</p>
    <p>Please click the link below to enter your new password and take control of your account.</p>
    <p>We're happy to have you aboard!</p>
    <a href="{{ url('password/reset/'.$token) }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Set New Password</a>
@stop