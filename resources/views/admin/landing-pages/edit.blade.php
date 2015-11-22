@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Edit Landing Page for Location: {{ $location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>
        <br>

        @include('errors.error-list')

        {!! Form::model($location->landingPage, ['method' => 'PUT', 'route' => ['admin.locations.landing-page.update', $location->id, $location->landingPage->id]]) !!}

        <label>Community Name
            {!! Form::text('name') !!}
        </label>

        @include('admin.landing-pages.form')

        {!! Form::submit('Update') !!}

        {!! Form::close() !!}
    </section>
@stop