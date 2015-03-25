@extends('layouts.main')
@section('header-text')
    <h2 class="jumbotron__heading">My Rentals</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">
                <a class="btn btn-primary btn-lg" href="{{ route('rental.create') }}" role="button">Create a New Rental</a>
                <hr>
                @if($rentals->count())
                    <table class="table table-striped table-hover">
                        <thead><tr><th>Active</th><th>Address</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr></thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr><td><button id="{{ $rental->id }}" type="button" title="{!! $rental->isActive() ? 'deactivate' : 'activate' !!}" class="rental-active btn {!! $rental->isActive() ? 'btn-success' : 'btn-danger' !!}">{!! $rental->isActive() ? 'Active' : 'Inactive' !!}</button></td><td>{{ $rental->getAddress() }}</td><td><a href="{{ route('rental.photos.index', $rental->id) }}"  class="btn btn-primary">Photos</a></td><td><a href="{{ route('rental.edit', $rental->id) }}" class="btn btn-primary">Edit</a></td><td><a class="btn btn-danger">Delete</a></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>{{ $rentals->count() }} rental{{ $rentals->count() == 1 ? '' : 's' }}.</p>
                @else
                    <p>No rentals.</p>
                @endif
            </div>
        </div>
    </div>
@stop
@section('footer')
<script src="/js/settings-rental-list.js"></script>
@stop




