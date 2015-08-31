@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.appliances.index') }}">Back to Appliance List</a>

        <h1>Delete an Appliance</h1>

        <p>Are you sure you want to delete the appliance <strong>{{ $appliance->name }}</strong>?</p>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.appliances.destroy', $appliance->id]]) !!}
        {!! Form::submit('Yes, Delete it') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.appliances.index') }}">Cancel</a>
    </section>
@stop