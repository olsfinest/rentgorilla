@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Delete a user</h1>
        <p>Are you sure you want to delete the user <strong> {{ $user->email }}</strong>?</p>
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id]]) !!}
        {!! Form::submit('Yes, Delete the user') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.searchUsers') }}">Cancel</a>
    </section>
@stop