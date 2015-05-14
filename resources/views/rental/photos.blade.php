@extends('layouts.main')
@section('header')
    <script src="/js/dropzone.js"></script>
    <link rel="stylesheet" href="/css/dropzone.css">
@stop
@section('header-text')
    <h2 class="jumbotron__heading">Photos for {{ $rental->street_address }}</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">
                {!! Form::open(['route' => ['rental.photos.store', $rental->uuid], 'class' => 'dropzone']) !!}
                {!! Form::close() !!}
                    @if($rental->photos->count())
                    <table class="table table-striped table-hover">
                        <tbody>
                        @foreach($rental->photos as $photo)
                            <tr><td><img width="237" height="158" src="{{ $photo->getSize('medium') }}"></td><td style="vertical-align:middle">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['photos.delete', $photo->id]]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                </td></tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p>{{ $rental->photos->count() }} photo{{ $rental->photos->count() == 1 ? '' : 's' }}.</p>
                @endif
            </div>
        </div>
    </div>
@stop





