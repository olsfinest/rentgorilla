@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.safeties.index') }}">Back to Safety and Security List</a>

        <h1>Edit Safety and Security Item</h1>

        @include('errors.error-list')
        {!! Form::model($safety, ['method' => 'PATCH', 'route' => ['admin.safeties.update', $safety->id]]) !!}
        <label for="">Service
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop