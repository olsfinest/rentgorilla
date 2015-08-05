@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Support</h1>
        <p>
            Thank you for choosing <strong>RentGorilla</strong>.
        </p>
        <p>
            We'd love to hear from you, whether you have feedback or a question. Please use the form below to send us a message, and we'll do our best to reply within 24 hours.
        </p>

        @include('errors.error-list')

        {!! Form::open(['route' => 'contact.send']) !!}
            <label for="question">Your Question
                {!! Form::textarea('question', null, ['placeholder' => 'Your question', 'rows' => 3, 'required']) !!}
            </label>
            {!! Form::submit('Send') !!}
        {!! Form::close() !!}
    </section>
@stop