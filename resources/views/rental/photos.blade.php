@extends('layouts.admin')
@section('head')
    <script src="/js/dropzone.js"></script>
    <link rel="stylesheet" href="/css/dropzone.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Photos for {{ $rental->street_address }}</h1>
        {!! Form::open(['route' => ['rental.photos.store', $rental->uuid], 'class' => 'dropzone']) !!}
{!! Form::close() !!}
@if($photoCount = $rental->photos->count())
    <table>
        <tbody>
        @foreach($rental->photos as $photo)
            <tr><td><img src="{{ $photo->getSize('small') }}"></td><td style="vertical-align:middle">
                {!! Form::open(['method' => 'DELETE', 'route' => ['photos.delete', $photo->name]]) !!}
                {!! Form::submit('Delete', ['class' => 'button']) !!}
                {!! Form::close() !!}
            </td></tr>
        @endforeach
        </tbody>
    </table>
    <p>{{ $photoCount }} photo{{ $photoCount == 1 ? '' : 's' }}.</p>
@endif
        <a href="{{ route('rental.index') }}" class="button">Done</a>
@stop





