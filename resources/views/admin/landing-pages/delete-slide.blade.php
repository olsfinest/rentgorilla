@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Delete Slide - Location: {{ $slide->landingPage->location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.landing-page.slides', [$slide->landingPage->location->id, $slide->landingPage->id]) }}" class="button">Back to Slides</a>
        <p>Are you sure you want to delete this slide? This action cannot be undone.</p>
        <br>
        <img src="/img/slides/{{ $slide->name }}">
        @if($slide->alt)
            <p>{{ $slide->alt }}</p>
        @endif
        <br>
        <br>
        @include('errors.error-list')
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.locations.landing-page.slides.destroy', $slide->landingPage->location->id, $slide->landingPage->id, $slide->name]]) !!}
        {!! Form::submit('Delete', ['class' => 'button']) !!}
        {!! Form::close() !!}
    </section>
@stop


















