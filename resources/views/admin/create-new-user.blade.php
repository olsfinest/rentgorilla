@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Create New User</h1>
        <p>Use this form to manually create a new user.</p>
        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.newUser']) !!}
        <label for="">First Name
            {!! Form::text('first_name') !!}
        </label>
        <label for="">Last Name
            {!! Form::text('last_name') !!}
        </label>
        <label for="">Email
            {!! Form::text('email') !!}
        </label>
        @if(Auth::user()->isSuper())
        <label for="">New User is an Administrator
            {!! Form::checkbox('is_admin') !!}
        </label>
        @endif
        {!! Form::submit('Create New User', ['name' => 'no-login']) !!}
        {!! Form::submit('Create New User and Login', ['name' => 'login']) !!}
        {!! Form::close() !!}
    </section>
@stop