@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>Edit Area</h1>
        <a href="{{ route('admin.areas.index') }}" class="button">List All Areas</a>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>

        @include('errors.error-list')

        {!! Form::model($area, ['method' => 'PATCH', 'route' => ['admin.areas.update', $area->id]]) !!}

       <label for="name">Name
       {!! Form::text('name', null, ['id' => 'name']) !!}
        </label>

        <label for="province">Province
            {!! Form::select('province', Config::get('rentals.provinces'), 'NS', ['id' => 'province', 'autocomplete' => 'off']) !!}
        </label>

        <br>

        {!! Form::submit('Update Area') !!}

        {!! Form::close() !!}
    </section>
@stop