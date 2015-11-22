@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Edit Location: {{ $location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>
        <br>

        @include('errors.error-list')
        {!! Form::model($location, ['method' => 'PATCH', 'route' => ['admin.locations.update', $location->id]]) !!}

        <label>Map Zoom Level
            {!! Form::text('zoom', null) !!}
        </label>

        {!! Form::submit('Update') !!}

        {!! Form::close() !!}
    </section>
@stop