@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.safeties.index') }}">Back to Safety and Security List</a>

        <h1>Delete a Safety and Security Item</h1>

        <p>Are you sure you want to delete the item <strong>{{ $safety->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.safeties.destroy', $safety->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.safeties.index') }}">Cancel</a>
    </section>
@stop