@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.heats.index') }}">Back to Heating List</a>

        <h1>Delete a Heating Type</h1>

        <p>Are you sure you want to delete the heating type <strong>{{ $heat->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.heats.destroy', $heat->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.heats.index') }}">Cancel</a>
    </section>
@stop