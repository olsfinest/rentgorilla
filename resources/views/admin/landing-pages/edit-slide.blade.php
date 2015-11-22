@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Edit Slide - Location: {{ $slide->landingPage->location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.landing-page.slides', [$slide->landingPage->location->id, $slide->landingPage->id]) }}" class="button">Back to Slides</a>
        <br>
        <img src="/img/slides/{{ $slide->name }}">
        <br>
        <br>
        @include('errors.error-list')
        {!! Form::model($slide, ['method' => 'PATCH', 'route' => ['slide.update', $slide->id]]) !!}

        <label>Alt text
            {!! Form::text('alt') !!}
        </label>

        {!! Form::submit('Update') !!}
        {!! Form::close() !!}
    </section>
@stop

