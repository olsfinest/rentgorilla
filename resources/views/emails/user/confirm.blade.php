@extends('emails.layouts.default')

@section('body')
    <p>Click the button below to confirm your account:</p>


    <a href="{{ url('register/confirm/'.$url_token) }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Confirm Account</a>
@stop