@extends('emails.layouts.default')

@section('body')

<h2>Almost there, {{ $first_name }}!</h2>

<div>
    <p>To complete your registration on RentGorilla.ca, simply click this link: {{ URL::to('register/confirm', [$url_token]) }}.</p>
</div>

@stop