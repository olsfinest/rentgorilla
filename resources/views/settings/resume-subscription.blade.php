@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Resume Subscription</h1>
        @if($plan->isLegacy())
            <p>Sorry, the plan <strong>{{ $plan->planName() }}</strong> is no longer supported.</p>
        @else
            @if(Auth::user()->cancelled() && Auth::user()->onGracePeriod())
                <p>You have previously cancelled your subscription to the <strong>{{ $plan->planName() }}</strong> plan.</p>
                <p>You have the option to resume it, and you will simply be billed on the original billing cycle.</p>
                <p>
                    @include('errors.error-list')
                    {!! Form::open(['route' => 'subscription.resumeSubscription']) !!}
                    {!! Form::submit('Resume Subscription', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </p>
            @else
                <p>Sorry, you must have cancelled your subscription and be within your originally scheduled plan expiry time in order to resume your subscription.</p>
            @endif
        @endif
    </section>
@stop
