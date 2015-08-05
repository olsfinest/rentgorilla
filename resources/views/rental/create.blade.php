@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    <section class="content full admin">
        <h1>Create a new rental</h1>
    @include('errors.error-list')
    {!! Form::model($rental = new \RentGorilla\Rental(), ['route' => 'rental.store', 'id' => 'modify_rental_form']) !!}
         @include('rental.form', ['submitButtonText' => 'Create and Add Photos'])
     {!! Form::close() !!}
    </section>
 @stop