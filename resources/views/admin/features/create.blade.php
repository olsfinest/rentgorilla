@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.features.index') }}">Back to Features List</a>

        <h1>Create A New Feature</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.features.store']) !!}
        <label for="">Feature
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop