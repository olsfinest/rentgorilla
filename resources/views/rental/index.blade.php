@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">My Properties</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">
                <a class="btn btn-primary btn-lg" href="{{ route('rental.create') }}" role="button">List a New Property</a>
                <hr>
                @if($rentals->count())
                    <table class="table table-striped table-hover">
                        <thead><tr><th>Active</th><th>Address</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr></thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr><td><button id="{{ $rental->uuid }}" type="button" title="{!! $rental->isActive() ? 'deactivate' : 'activate' !!}" class="rental-active btn {!! $rental->isActive() ? 'btn-success' : 'btn-danger' !!}">{!! $rental->isActive() ? 'Active' : 'Inactive' !!}</button></td><td>{{ $rental->getAddress() }}</td><td><a href="{{ route('rental.photos.index', $rental->uuid) }}"  class="btn btn-primary">Photos</a></td><td><a href="{{ route('rental.edit', $rental->uuid) }}" class="btn btn-primary">Edit</a></td><td><a class="btn btn-danger">Delete</a></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>{{ $rentals->count() }} {{ $rentals->count() == 1 ? 'property' : 'properties' }}.</p>
                @else
                    <p>No properties.</p>
                @endif
            </div>
        </div>
    </div>
@stop
@section('footer')
<script src="/js/settings-rental-list.js"></script>
@stop




