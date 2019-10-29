@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.utilities.index') }}">Back to Utilities List</a>

        <h1>Create A New Utility</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.utilities.store']) !!}
        <label for="">Utility
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop