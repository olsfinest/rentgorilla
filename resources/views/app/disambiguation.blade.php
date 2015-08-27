@extends('layouts.app')
@section('content')
    @include('partials.header')

    <section class="main">
        <article class="content full">

            <h2>We have a few places like that!</h2>

            <ul>
            @foreach($locations as $location)
                <li><a href="{{ route('list', ['slug' => $location->slug]) }}">{{ $location->city }}, {{ $location->province }}</a></li>
            @endforeach
            </ul>

        </article>
    </section>
@endsection
