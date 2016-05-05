@extends('emails.layouts.default')

@section('body')
    <p>The was an inquiry about your property <strong>{{ $address }}</strong>
    <p>(In most cases you may simply reply to this email to respond, however please ensure you are replying to "{{ $the_email }}" and not "{{ config('mail.from.address') }}")</p>
    <p>Name: {{ $the_name }}</p>
    <p>Email: {{ $the_email }}</p>
    <p>Message:  {!! nl2br(e($the_message)) !!}</p>
@stop