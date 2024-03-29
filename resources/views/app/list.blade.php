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
			<!-- List View -->
			<div id="list-canvas" class="listings view">

			</div>
            <div style="text-align: center">
                <button style="display: none; margin-bottom: 20px;" class="button" id="nextPageBtn">Load More Results</button>
            </div>
	</section>
@endsection
@section('footer')
            <!--jQuery-->

            <!-- Cookies -->
            <!--	<script src="/js/jquery-cookie-1.4.1/jquery.cookie.js"></script> -->
            <!-- Charts -->
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<!-- Cycle -->
			<script src="/js/cycle.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
			<!-- Custom JavaScript -->
			<!-- <script type="text/javascript" src="/js/min/custom.min.js"></script> -->
			<script type="text/javascript" src="/js/list-view.js?v=8"></script>
@endsection