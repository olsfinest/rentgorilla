@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">Resume Subscription</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">

                @if(Auth::user()->subscribed() && Auth::user()->cancelled())
                <p>
                    Your subscription to the <strong>{{ $planName }}</strong> plan expires {{ $expiryDate->format('F dS, Y') }}. ({{ $expiryDate->diffForHumans() }})
                </p>
                <p>
                    If you choose to resume it, you will not be billed immediately, but simply billed on the original billing cycle.
                </p>

                <p>
                    {!! Form::open(['route' => 'subscription.resumeSubscription']) !!}

                    {!! Form::submit('Resume Subscription', ['class' => 'btn btn-primary']) !!}


                    {!! Form::close() !!}
                </p>
                @elseif(Auth::user()->subscribed() && ! Auth::user()->cancelled())
                    <div class="alert alert-success">You have are actively subscribed to the plan {{ $planName }}.</div>
                @endif
            </div>
        </div>
    </div>
@stop