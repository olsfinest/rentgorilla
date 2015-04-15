@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">My Favourites</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">
                @if($favourites->count())
                    <table class="table table-striped table-hover">
                        <tbody>
                        @foreach($favourites as $favourite)
                            <tr><td><img width="237" height="158" src="{{ $favourite->photos()->first()->name }}"></td>
                                <td style="vertical-align:middle">
                                    <ul class="listing_attributes">
                                        <li class="address">{!! str_limit($favourite->street_address, 20) !!}</li>
                                        <li class="description">{!! ucwords($favourite->type) !!} - {!! $favourite->beds !!} {!! $favourite->beds == 1 ? 'Bed' : 'Beds' !!}</li>
                                        <li class="available">Available: {!! $favourite->available_at->format('M jS, Y') !!}</li>
                                        <li class="price">${!! $favourite->price !!}</li>
                                    </ul></td>
                                <td style="vertical-align:middle">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['favourites.delete', $favourite->uuid]]) !!}
                                    {!! Form::submit('Remove', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                     </td></tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p>{{ $favourites->count() }} favourite{{ $favourites->count() == 1 ? '' : 's' }}.</p>
                @else
                    <p>No favourites yet.</p>
                @endif
            </div>
        </div>
    </div>
@stop



