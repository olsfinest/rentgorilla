@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.safeties.index') }}">Back to Safety and Security List</a>

        <h1>Create A New Safety and Security Item</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.safeties.store']) !!}
        <label for="">Safety
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop