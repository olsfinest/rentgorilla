@extends('emails.layouts.default')

@section('body')

    <p>Unfortunately your account has expired and your properties have been deactivated.</p>
    <p>Should you wish to resume your subscription, please click the button below:</p>
    <a href="{{ route('changePlan') }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Resume Subscription</a>
@stop