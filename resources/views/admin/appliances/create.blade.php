@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.appliances.index') }}">Back to Appliance List</a>

        <h1>Create A New Appliance</h1>

        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.appliances.store']) !!}
        <label for="">Appliance
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Create') !!}
        {!! Form::close() !!}
    </section>
@stop