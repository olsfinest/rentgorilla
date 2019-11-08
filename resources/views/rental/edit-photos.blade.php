@extends('layouts.admin')
@section('content')
    <section class="content full admin">
        <h1>Rotate Photo</h1>
        <img src="{{ $photo->getSize('small') }}">
        @include('errors.error-list')
        {!! Form::open(['method' => 'PATCH', 'route' => ['photos.rotate', $photo->name]]) !!}
        {!! Form::radio('orientation', '-90', old('orientation') == '-90') !!} <label>90&deg; clockwise</label><br>
        {!! Form::radio('orientation', '90', old('orientation') == '90') !!} <label>90&deg; counter-clockwise</label><br>
        {!! Form::radio('orientation', '180', old('orientation') == '180') !!} <label>180&deg;</label><br>
        {!! Form::submit('Rotate', ['class' => 'button']) !!}
        {!! Form::close() !!}
        <br><a href="{{ route('rental.photos.index', $photo->rental->uuid) }}" class="button">Back to Photos</a>
        <br><a href="{{ route('dashboard.index') }}" class="button">Back to Dashboard</a>
    </section>
@endsection