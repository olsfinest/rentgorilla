@extends('emails.layouts.default')

@section('body')
    <p>Congratulations! You have earned the achievement badge <strong>{{ $achievement }}</strong>!</p>
    <p><strong>{{ $points }}</strong> points have been applied to your account.</p>
    <p>You now have <strong>{{ $total }}</strong> points, which can be exchanged for credit on your next bill if you have a minimum of 10,000 points and an active subscription!</p>
    <p>Click <a href="https://rentgorilla.ca/admin/subscription/plan">here</a> to learn more about how you can earn more points every month.</p>
@stop