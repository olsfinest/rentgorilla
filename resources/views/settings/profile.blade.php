@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">Edit Your Profile</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">
                @include('errors.error-list')

                {!! Form::model(is_null($profile) ? new \RentGorilla\Profile() : $profile, ['route' => 'profile.update']) !!}
                <div class="form-group">
                    <label>Phone:</label>
                    {!! Form::text('primary_phone', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>Alternate Phone:</label>
                    {!! Form::text('alternate_phone', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="">Website:</label>
                    {!! Form::text('website', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="">Bio:</label>
                    {!! Form::textarea('bio', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Update Profile">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop