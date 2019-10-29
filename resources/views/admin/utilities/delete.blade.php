@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.utilities.index') }}">Back to utilities List</a>

        <h1>Delete a utility</h1>

        <p>Are you sure you want to delete the utility <strong>{{ $utility->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.utilities.destroy', $utility->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.utilities.index') }}">Cancel</a>
    </section>
@stop