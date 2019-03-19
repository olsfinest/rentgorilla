@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.services.index') }}">Back to Services List</a>

        <h1>Delete a Service</h1>

        <p>Are you sure you want to delete the service <strong>{{ $service->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.services.destroy', $service->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.services.index') }}">Cancel</a>
    </section>
@stop