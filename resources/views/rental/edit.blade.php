@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">Edit Property</h2>
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
                {!! Form::model($rental, ['method' => 'PATCH', 'route' => ['rental.update', $rental->uuid], 'class' => 'form-horizontal', 'id' => 'modify_rental_form']) !!}
                    @include('rental.form', ['submitButtonText' => 'Update'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
