@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
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

        <label for="area_id">Area
            {!! Form::select('area_id', $areas, null, ['id' => 'area_id', 'autocomplete' => 'off']) !!}
        </label>

        {!! Form::submit('Update') !!}

        {!! Form::close() !!}
    </section>
@stop