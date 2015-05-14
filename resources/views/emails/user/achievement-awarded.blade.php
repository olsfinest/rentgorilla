@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>Congratulations! You have earned the achievement <strong>{{ $achievement }}</strong>!</p>
        <p><strong>{{ $points }}</strong> points have been applied to your account.</p>
        <p>You now have <strong>{{ $total }}</strong> points, which can be exchanged for credit on your next bill if you have an active subscription!</p>
        <p>- The RentGorilla.ca team</p>
    </div>

@stop