@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>Confirm Delete Area</h1>
        <a href="{{ route('admin.areas.index') }}" class="button">List All Areas</a>

        <h2>{{ $area->nameAndProvince() }}</h2>

        @if($area->locations->count())
            <p>Cannot delete this area as the following locations reference it:</p>
            <ul>
            @foreach($area->locations as $location)
                <li>{{ $location->cityAndProvince() }}</li>
            @endforeach
            </ul>
        @endif

        <br>
        <br>
        {!! Form::open(['route' => ['admin.areas.destroy', $area->id], 'method' => 'DELETE', 'id' => 'delete_areas_form' ]) !!}

        {!! Form::submit('Delete Area') !!}

        {!! Form::close() !!}
    </section>
@stop