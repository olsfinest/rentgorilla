@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Confirm Cancel Promotion</h1>
        <p>Are you sure you wish to cancel the following promotion?</p>

        <ul>
            <li><strong>Location:</strong> {{ $rental->location->cityAndProvince() }}</li>
            <li><strong>Address:</strong> {{ $rental->street_address }}</li>
        </ul>

        <p>This action cannot be undone</p>

        {!! Form::open(['method' => 'POST', 'route' => ['admin.free-promotions.cancel', $rental->uuid]]) !!}

            {!! Form::submit('Cancel Promotion') !!}

        {!! Form::close() !!}

        <p><a href="{{ route('admin.free-promotions.index', $rental->location->slug) }}" class="button">No, Do not Cancel</a></p>
    </section>
@stop