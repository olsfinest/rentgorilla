@extends('layouts.app')

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


@if($loc && $loc->landingPage && $showLandingPage)
            <section class="locale">
                <div class="close_box fa fa-close"></div>
                <div class="images cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="1000">
                    @foreach($loc->landingPage->slides as $slide)
                        <img src="/img/slides/{{ $slide->name }}" alt="{{ $slide->alt }}">
                    @endforeach
                </div>
                <div class="content">
                    <h1>{{ $loc->landingPage->name }}</h1>
                    <div class="locale_meta">
                        <img src="/img/flags/{{ $loc->province }}.jpg" alt="">
                        <p>{{ $loc->rentals()->count() }} Listings</p>
                    </div>
                    <div class="cf"></div>
                    <p>
                        {{ $loc->landingPage->description }}
                    </p>
                    <h2>Statistics</h2>
                    <table class="stats">
                        @if($housePrice = $loc->averagePrice(\RentGorilla\Rental::HOUSE))
                            <tr>
                                <td>Avg. House Rental Cost</td>
                                <td>${{ $housePrice  }}</td>
                            </tr>
                        @endif
                        @if($apartmentPrice = $loc->averagePrice(\RentGorilla\Rental::APARTMENT))
                            <tr>
                                <td>Avg. Apartment Cost</td>
                                <td>${{ $apartmentPrice  }}</td>
                            </tr>
                        @endif
                        @if($roomPrice = $loc->averagePrice(\RentGorilla\Rental::ROOM))
                            <tr>
                                <td>Avg. Room Cost</td>
                                <td>${{ $roomPrice }}</td>
                            </tr>
                        @endif

                            @if($monthlySearches = $loc->getMonthlySearches())
                                <tr>
                                    <td>Searches for {{ date('F') }}</td>
                                    <td>{{ $monthlySearches }}</td>
                                </tr>
                            @endif
                    </table>
                </div>
            </section>
@endif
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
			<script type="text/javascript" src="/js/list-view.js?v=6"></script>
@endsection