@extends('emails.layouts.default')

@section('body')

    <h2>Support Request</h2>

    <div>
        <p><strong>Name:</strong> {{ $theName }} </p>
        <p><strong>Email:</strong> {{ $email }} </p>
        @if( ! is_null($phone))
            <p><strong>Phone:</strong> {{ $phone }} </p>
        @endif
        <p>{{ $question }}</p>
    </div>

@stop