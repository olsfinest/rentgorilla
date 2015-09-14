
@if($rentals->count())
    <section class="content full">
        <h1 style="float: left; width: 70%">{{ $total }} {{ $total == 1 ? 'result' : 'results' }}</h1>
            {!! Form::select('sort', Config::get('sort'), Session::get('sort') ?: 'available_at-ASC', ['class' => 'sort', 'id' => 'sort-widget', 'title' => 'Sort your results']) !!}
     <div class="cf"></div>
    </section>
    <ul id="rental-list">
        @include('app.rental-list-hits-partial')
    </ul>
@else
    <h1>Sorry, we couldn't find anything matching your search.</h1>
@endif