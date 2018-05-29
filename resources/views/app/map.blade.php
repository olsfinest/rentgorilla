@extends('layouts.app')

@section('title', $loc->city . ' Apartments & Houses for Rent on RentGorilla.ca')

@section('content')
        @include('partials.header')
        <section class="filter">
            <section class="main">
                <section class="content full">
                    @include('partials.search-form')
                    <div class="cf"></div>
                </section>
            </section>
        </section>
        <section class="main">
	        <div id="map-canvas" class="view active"></div>
		</section>
@endsection
@section('footer')
        <!--Maps-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
        <script type="text/javascript" src="/js/infobox.js"></script>
        <script type="text/javascript" src="/js/markerclusterer.js?v=1"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
        <script>
           @if($loc->zoom)
                var zoom = {{ $loc->zoom }};
            @else
                var zoom = 12;
            @endif
        </script>
        <script type="text/javascript" src="/js/map-view.js?v=2"></script>
        <script>
            $(window).load(function(){
                $('body').addClass('map');
            });
        </script>
@endsection