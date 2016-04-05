@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Delete a user</h1>
        <p>Are you sure you want to delete the user <strong> {{ $user->email }}</strong>?</p>
        <p>This will remove the following user information (if any):</p>
        <ul>
            <li>Profile photos</li>
            <li>Rental photos</li>
            <li>Stripe account</li>
            <li>All associated database information</li>
            <p><em>Note: deleted customers can still be retrieved through the Stripe API, in order to be able to track the history of customers while still removing their credit card details and preventing any further operations to be performed (such as adding a new subscription).</em></p>
        </ul>
        <p><strong>This action cannot be undone.</strong></p>
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id]]) !!}
        {!! Form::submit('Yes, Delete the user') !!}
        {!! Form::close() !!}
        <a class="button" href="{{ route('admin.searchUsers') }}">Cancel</a>
    </section>
@stop