@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.features.index') }}">Back to Features List</a>

        <h1>Delete a Feature</h1>

        <p>Are you sure you want to delete the feature <strong>{{ $feature->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.features.destroy', $feature->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.features.index') }}">Cancel</a>
    </section>
@stop