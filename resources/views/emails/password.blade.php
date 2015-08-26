@extends('emails.layouts.default')

@section('body')
    <p>Please click the button below to reset your password:</p>

    @include('emails.user.partials.button', ['route' => url('password/reset/'.$token), 'title' => 'Reset Password'])
@stop