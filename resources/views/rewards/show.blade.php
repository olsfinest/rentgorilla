@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
<section class="content full admin">
    <h1>Redeem Points</h1>
    @include('errors.error-list')
    @if(Auth::user()->points >= \RentGorilla\User::POINT_REDEMPTION_THRESHOLD && Auth::user()->stripeIsActive())
        <p>You currently have {{ Auth::user()->points }} reward points.</p>
        <p>Please note points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments.</p>
        <p>You may redeem them now for a ${{ Auth::user()->getPointsMonetaryValue() }} credit on your next bill.</p>
        {!! Form::open(['method' => 'POST', 'route' => 'redeem.create']) !!}
            <input class="" type="submit" value="Redeem Points">
        {!! Form::close() !!}
    @elseif(Auth::user()->points >= \RentGorilla\User::POINT_REDEMPTION_THRESHOLD && ! Auth::user()->stripeIsActive())
        <p>You currently have {{ Auth::user()->points }} reward points.</p>
        <p>Please note points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments.</p>
        <p>However, to redeem your points you must have an active subscription.</p>
    @else
        <p>You currently have {{ Auth::user()->points }} reward points.</p>
        <p>As points are redeemed in {{ \RentGorilla\User::POINT_REDEMPTION_THRESHOLD  }} point increments, you do not have enough points to redeem at this time.</p>
    @endif
</section>
<section class="content full admin">
    <h1>Earn Credit With RentGorilla Achievements</h1>
    <div class="achievements_container">
        <p>
            Earn credit towards your plan with RentGorilla achievements. Each achievement earns you points that you can redeem. Some achievements are even awarded monthly!
        </p>
        @foreach(Config::get('rewards') as $reward => $rewardProps)
            <section id="{{ $reward }}" class="settingsPanel">
                <section class="settingsLabel">
                    <strong>{{ $rewardProps['name'] }}</strong>
                    <p>
                        {{ $rewardProps['points'] . ($rewardProps['monthly'] ? ' points / month' : ' points') }}
                    </p>
                </section>
                <section class="settingsContent">
                    <p>
                        {{ $rewardProps['description'] }}
                    </p>
                </section>
                <span class="cf"></span>
            </section>
        @endforeach
    </div>
</section>
@stop