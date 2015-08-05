@extends('emails.layouts.default')

@section('body')
    <p>Congratulations! You have redeemed {{ $redeemedPoints }} points.
    <p>A credit of ${{ $credit }} has been applied to your account.</p>
    <p>You now have {{ $currentPoints }} points remaining.</p>
@stop