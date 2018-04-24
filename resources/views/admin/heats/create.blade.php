@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.heats.index') }}">Back to Heating Type List</a>

        <h1>Create A New Heating Type</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.heats.store']) !!}
        <label for="">Heating Type
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop