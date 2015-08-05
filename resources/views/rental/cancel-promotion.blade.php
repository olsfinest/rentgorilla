@extends('layouts.admin')

@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop

@section('content')
    <section class="content full admin">

        <h1>Cancel promotion for {{ $rental->street_address  }}</h1>
        <p>Your promotion will begin approximately <strong>{{ $queued['dateAvailable']->format('F jS, Y') }}, ({{ $queued['daysRemaining'] }} days from now)</strong> </p>
        <p>If you wish to cancel your scheduled promotion click the button below.</p>
        <p>Please note we do not charge your credit card until a promotion actually begins.</p>

         {!! Form::open(['method' => 'DELETE', 'route' => ['promotions.delete', $rental->uuid]]) !!}

            {!! Form::hidden('rental_id', $rental->uuid) !!}

            {!! Form::submit('Cancel Promotion') !!}

            {!! Form::close() !!}

        <a class="button" href="{{ route('rental.index') }}">Do not cancel</a>

    </section>
@stop



