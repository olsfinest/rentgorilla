@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.features.index') }}">Back to Features List</a>

        <h1>Edit Feature</h1>

        @include('errors.error-list')
        {!! Form::model($feature, ['method' => 'PATCH', 'route' => ['admin.features.update', $feature->id]]) !!}
        <label for="">Feature
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop