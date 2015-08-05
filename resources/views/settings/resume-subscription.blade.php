@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Resume Subscription</h1>
        <p>You have previously cancelled your subscription to the <strong>{{ $plan }}</strong> plan.</p>
        <p>You have the option to resume it, and you will simply be billed on the original billing cycle.</p>
        <p>
            {!! Form::open(['route' => 'subscription.resumeSubscription']) !!}
            {!! Form::submit('Resume Subscription', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </p>
    </section>
@stop
