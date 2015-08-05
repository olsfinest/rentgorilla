@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@endsection
@section('content')
    @include('partials.settings-header')
    <section class="content full admin">
        <h1>Manage Settings</h1>
        <p>We'll send you a monthly report on your properties if this checkbox is checked.</p>
        @include('errors.error-list')
        {!! Form::model(Auth::user()) !!}
        <label>Receive monthly emails:
            {!! Form::checkbox('monthly_emails') !!}
        </label>
        <input type="submit" value="Save">
        {!! Form::close() !!}
    </section>
@stop