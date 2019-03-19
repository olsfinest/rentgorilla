@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.services.index') }}">Back to Services List</a>

        <h1>Edit Service</h1>

        @include('errors.error-list')
        {!! Form::model($service, ['method' => 'PATCH', 'route' => ['admin.services.update', $service->id]]) !!}
        <label for="">Service
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop