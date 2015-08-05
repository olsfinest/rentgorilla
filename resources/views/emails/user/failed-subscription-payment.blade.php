@extends('emails.layouts.default')

@section('body')
    <p>We attempted to charge your credit card for your normal subscription, however the charge failed.</p>
    <p>We have cancelled your subscription, however you may update your credit card details and resubscribe at any time.</p>
    <a href="{{ route('updateCard') }}" id="" style="background:#73B063; display:inline-block; width:100%;
					margin:0 auto; box-sizing:border-box; text-align:center;font-size:1.5em; font-weight:bold; padding:15px; color:white; text-decoration:none;">Update Card</a>
@stop