@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Cancellation</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
            @if(! Auth::user()->cancelled())

            <p class="breather">
                     Are you really sure that you want to cancel your subscription?
                 </p>

                 <p>
                     {!! Form::open(['route' => 'subscription.cancelSubscription']) !!}

                     {!! Form::submit('Cancel Subscription', ['class' => 'btn btn-primary btn-danger']) !!}


                     {!! Form::close() !!}
                 </p>
           @else
                <div class="alert alert-success">Your subscription has been cancelled.</div>
           @endif
        </div>
    </div>
</div>
@stop