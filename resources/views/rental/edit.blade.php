@extends('layouts.admin')
@section('head')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/form.css?v=1">
@stop
@section('content')
    <section class="content full admin">
        <h1><i class="fa fa-pencil-square"></i> Edit rental</h1>
        @include('errors.error-list')
        {!! Form::model($rental, ['method' => 'PATCH', 'route' => ['rental.update', $rental->uuid], 'class' => 'form-horizontal', 'id' => 'modify_rental_form']) !!}
        @include('rental.form', ['submitButtonText' => 'Update'])
        {!! Form::close() !!}
        <a href="{{ route('rental.index') }}" class="button">Cancel</a>
    </section>
@stop