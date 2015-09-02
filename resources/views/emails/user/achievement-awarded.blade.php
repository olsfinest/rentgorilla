@extends('emails.layouts.default')

@section('body')
    <p>Congratulations! You have earned the achievement badge <strong>{{ $achievement }}</strong>!</p>
    <p><strong>{{ $points }}</strong> points have been applied to your account.</p>
    <p>You now have <strong>{{ $total }}</strong> points, which can be exchanged for credit on your next bill if you have an active subscription!</p>
@stop