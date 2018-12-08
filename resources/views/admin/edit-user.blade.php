@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>User Info - {{ $user->email }}</h1>
        @if($profilePhoto = $user->getProfilePhoto('large'))
            <img class="settingsPhoto" src="{{ $profilePhoto }}">
        @endif
        <ul>
            <li>User ID: {{ $user->id }}</li>
            <li>Is an Admin: {{ $user->isAdmin() ? 'Yes' : 'No' }}</li>
            <li>Joined: {{ $user->created_at }} ({{ $user->created_at->diffForHumans() }})</li>
            <li>Confirmed: {{ $user->confirmed ? 'Yes' : 'No' }}</li>
            <li>Authenticated via: {{ $user->provider }}</li>
            <li>On Free Plan: {{ $user->isOnFreePlan() ? 'Yes' : 'No' }}</li>
            <li>Ever Used Credit Card: {{ $user->readyForBilling() ? 'Yes' : 'No' }}</li>
            <li>Last 4: {{ $user->last_four ? $user->last_four : 'n/a' }}</li>
            <li>Active Stripe Subscription: {{ $user->stripeIsActive() ? 'Yes' : 'No' }}</li>
            <li>Stripe Id: {{ $user->hasStripeId() ? $user->getStripeId() : 'n/a' }}</li>
            <li>Subscription Plan: {{ $user->getStripePlan() ? $user->getStripePlan() : 'n/a' }}</li>
            <li>Current Period End: {{ $user->current_period_end ? $user->current_period_end . ' (' . $user->current_period_end->diffForHumans() . ')' : 'n/a' }}</li>
            <li>Subscription Ends: {{ $user->subscription_ends_at ? $user->subscription_ends_at . ' (' . $user->subscription_ends_at->diffForHumans() . ')' : 'n/a' }}</li>
            <li>On Trial: {{ $user->onTrial() ? 'Yes' : 'No' }}</li>
            <li>Trial Ends: {{ $user->trial_ends_at ? $user->trial_ends_at . ' (' . $user->trial_ends_at->diffForHumans() . ')'  : 'n/a' }}</li>
            <li>Points: {{ $user->points }}</li>
        </ul>
        <br>
        <hr>
        <h1>Edit User</h1>
        @include('errors.error-list')
        {!! Form::model($user, ['route' => ['admin.user.update', $user->id],'method' => 'PATCH']) !!}
        <label for="">First Name
            {!! Form::text('first_name') !!}
        </label>
        <label for="">Last Name
            {!! Form::text('last_name') !!}
        </label>
        <label for="">Email
            {!! Form::text('email') !!}
        </label>
        {!! Form::submit('Update User') !!}
        {!! Form::close() !!}
        <br>
        <hr>
        <h1>Properties ({{ $active }} active)</h1>
        @if(count($rentals))
            <ul>
                @foreach($rentals as $rental)
                    <li>{{ $rental->isActive() ? '[active]' : ''}} <a href="{{ route('rental.preview', $rental->uuid) }}"> {{ $rental->getAddress() }}</a></li>
                @endforeach
            </ul>
        @else
            <p>No properties.</p>
        @endif
        <br>
        <hr>
        <h1>Delete User</h1>
        <a class="button" href="{{ route('admin.user.confirmDelete', $user->id) }}">Delete User</a>
    </section>
@stop