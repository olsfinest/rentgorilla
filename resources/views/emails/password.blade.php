@extends('emails.layouts.default')

@section('body')
    <p>Please click the button below to reset your password:</p>
    <a href="{{ url('password/reset/'.$token) }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Reset Password</a>
@stop