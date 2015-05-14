@if($rentals->count())
    <h1>{{ $total }} {{ $total == 1 ? 'result' : 'results' }}</h1>
    <ul id="rental-list">
        @include('app.rental-list-hits-partial')
    </ul>
@else
    <h1>Sorry, we couldn't find anything matching your search.</h1>
@endif