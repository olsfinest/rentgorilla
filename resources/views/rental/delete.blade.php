@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Delete {{ $rental->street_address }}</h1>
        <p>Are you sure you want to delete this rental? This action cannot be undone.</p>
        {!! Form::open(['method' => 'DELETE', 'route' => ['rental.destroy', $rental->uuid]]) !!}
        {!! Form::submit('Yes, Delete') !!}
        <a href="{{ route('rental.index') }}" class="button">Cancel</a>

    </section>
@stop