@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Cancel Subscription</h1>
        @if(Auth::user()->stripeIsActive())
            <p>Are you really sure that you want to cancel your subscription?</p>
            <p>If you decide to cancel, your subscription will stay active for the time for which you have paid. (Until {{ Auth::user()->getCurrentPeriodEnd()->format('F jS, Y') }}).</p>
            {!! Form::open(['route' => 'subscription.cancelSubscription']) !!}
            {!! Form::submit('Cancel Subscription', ['class' => 'btn btn-primary btn-danger']) !!}
            {!! Form::close() !!}
            <a href="{{ route('changePlan') }}" class="button">Do not cancel</a>
        @else
            <p>You do not have an active subscription.</p>
        @endif
    </section>
@stop