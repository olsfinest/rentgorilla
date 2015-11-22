@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Create Landing Page for Location: {{ $location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>

        @include('errors.error-list')

        {!! Form::open(['route' => ['admin.locations.landing-page.store', $location->id]]) !!}

        <label>Community Name
            {!! Form::text('name', $location->city) !!}
        </label>

        @include('admin.landing-pages.form')

        <br>

        {!! Form::submit('Create Landing Page') !!}

        {!! Form::close() !!}

    </section>
@stop