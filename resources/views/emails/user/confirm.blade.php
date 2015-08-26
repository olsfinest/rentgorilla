@extends('emails.layouts.default')

@section('body')
    <p>Please click the button below to confirm your account:</p>

    @include('emails.user.partials.button', ['route' => url('register/confirm/'.$url_token), 'title' => 'Confirm Account'])
@stop