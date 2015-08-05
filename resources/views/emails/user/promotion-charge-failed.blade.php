@extends('emails.layouts.default')

@section('body')
    <p>The promotion for your property <strong>{{ $address }}</strong> was not able to begin as intended because we attempted to charge your credit card and it failed.</p>
    <p>If you still wish to promote your property, please update your credit card information and try again.</p>
    <a href="{{ route('updateCard') }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Update Credit Card</a>
@stop