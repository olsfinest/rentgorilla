@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">Create a New Rental</h2>
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
                {!! Form::model(new \RentGorilla\Rental(), ['class' => 'form-horizontal']) !!}
                    @include('rental.form', ['submitButtonText' => 'Create'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
