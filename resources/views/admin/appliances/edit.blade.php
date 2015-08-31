@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">

        <a class="button" href="{{ route('admin.appliances.index') }}">Back to Appliance List</a>

        <h1>Edit Appliance</h1>

        @include('errors.error-list')
        {!! Form::model($appliance, ['method' => 'PATCH', 'route' => ['admin.appliances.update', $appliance->id]]) !!}
        <label for="">Appliance
            {!! Form::text('name') !!}
        </label>
        {!! Form::submit('Save') !!}
        {!! Form::close() !!}
    </section>
@stop