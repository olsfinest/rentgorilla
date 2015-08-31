@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.heats.index') }}">Back to Heating Type List</a>

        <h1>Edit Heating Type</h1>

        @include('errors.error-list')
        {!! Form::model($heat, ['method' => 'PATCH', 'route' => ['admin.heats.update', $heat->id]]) !!}
        <label for="">Heating Type
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop