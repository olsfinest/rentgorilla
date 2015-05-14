@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">Redeem Rewards</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-6">
            @include('errors.error-list')
            @if(Auth::user()->points >= \RentGorilla\User::POINT_REDEMPTION_THRESHOLD && Auth::user()->stripeIsActive())
                <p>You currently have {{ Auth::user()->points }} reward points.</p>
                <p>Please note points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments.</p>
                <p>You may redeem them now for a ${{ Auth::user()->getPointsMonetaryValue() }} credit on your next bill.</p>
                <div class="col-md-8">
                    {!! Form::open(['method' => 'POST', 'route' => 'redeem.create']) !!}
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Redeem Points">
                    </div>
                    {!! Form::close() !!}
                </div>
            @elseif(Auth::user()->points >= \RentGorilla\User::POINT_REDEMPTION_THRESHOLD && ! Auth::user()->stripeIsActive())
                <p>You currently have {{ Auth::user()->points }} reward points.</p>
                <p>Please note points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments.</p>
                <p>However, to redeem your points you must have an active subscription.</p>
            @else
                <p>You currently have {{ Auth::user()->points }} reward points.</p>
                <p>As points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments, you not have enough points to redeem at this time.</p>
            @endif
        </div>
    </div>
@stop