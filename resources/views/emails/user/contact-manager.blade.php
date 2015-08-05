@extends('emails.layouts.default')

@section('body')
    <p>The was an inquiry about your property <strong>{{ $address }}</strong>
    <p>(You may simply reply to this email to respond.)</p>
    <p>Name: {{ $the_name }}</p>
    <p>Email: {{ $the_email }}</p>
    <p>Message: {{ nl2br($the_message) }}</p>
@stop