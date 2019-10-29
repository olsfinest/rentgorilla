@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.utilities.index') }}">Back to utilities List</a>

        <h1>Edit Utility</h1>

        @include('errors.error-list')
        {!! Form::model($utility, ['method' => 'PATCH', 'route' => ['admin.utilities.update', $utility->id]]) !!}
        <label for="">Utility
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop