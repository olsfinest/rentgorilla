@extends('layouts.app')
@section('content')
        @include('partials.header')
        <section class="filter">
            @include('partials.search-form')
            <div class="cf"></div>
        </section>
        <section class="main">
	        <div id="map-canvas" class="view active"></div>
		</section>
@endsection
@section('footer')
        <!--Maps-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        <script type="text/javascript" src="/js/infobox.js"></script>
        <script type="text/javascript" src="/js/markerclusterer.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
        <script type="text/javascript" src="/js/map-view.js?v=1"></script>
@endsection