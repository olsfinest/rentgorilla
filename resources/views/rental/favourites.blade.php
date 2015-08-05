@extends('layouts.admin')
@section('head')

@stop
@section('content')
          <!-- List View -->
        <div id="list-canvas" class="listings view">
            <h1>Favourites</h1>
            <ul id="rental-list">
            @if($rentals->count())
                    @include('app.rental-list-hits-partial')
            @else
                <p>No favourites yet.</p>
            @endif
            </ul>
        </div>
@stop

@section('footer')
    <script src="/js/cycle.js"></script>
    <script src="/js/favourites-view.js"></script>
@endsection