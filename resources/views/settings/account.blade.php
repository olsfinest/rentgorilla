@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Edit Your Account</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
            {!! Form::model($user, ['method' => 'PATCH']) !!}
                <div class="form-group">
                    <label for="email">Email:</label>
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" name="password" type="password" value="" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation:</label>
                    <input class="form-control" name="password_confirmation" type="password" value="" id="password_confirmation">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Update Account">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop