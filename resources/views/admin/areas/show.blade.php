@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>Area</h1>
        <a href="{{ route('admin.areas.index') }}" class="button">List All Areas</a>

        <h2>{{ $area->nameAndProvince() }}</h2>

        @if($area->locations->count())
            <ul>
                @foreach($area->locations as $location)
                    <li>{{ $location->cityAndProvince() }}</li>
                @endforeach
            </ul>
        @else
            <p>No locations associated with this area yet.</p>
        @endif

        <br>

        <br>
    </section>
@stop