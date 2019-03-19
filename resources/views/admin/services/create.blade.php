@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.services.index') }}">Back to Services List</a>

        <h1>Create A New Service</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.services.store']) !!}
        <label for="">Service
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop