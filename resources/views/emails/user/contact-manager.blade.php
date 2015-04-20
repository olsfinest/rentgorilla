@extends('emails.layouts.default')

@section('body')

    <h2>Hi, {{ $first_name }}!</h2>

    <div>
        <p>The was an inquiry about your property <strong>{{ $address }}</strong>
        <p>(You may simply reply to this email to respond.)</p>
        <p>Name: {{ $name }}</p>
        <p>Email: {{ $email }}</p>
        <p>Message: {{ $the_message }}</p>
    </div>

@stop