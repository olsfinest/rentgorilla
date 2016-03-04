
@if($rentals->count())
	@if($loc && $loc->landingPage)
	<section class="localeNew {{ $showLandingPage ? 'open' : 'closed' }}">
		<section class="content full">
			<h2 class="showButton">View Community Profile, Links &amp; Statistics</h2>
			<div class="showMe">
				<div class="left">
					<h1>{{ $loc->landingPage->name }} <span>{{ $loc->rentals()->where('active', 1)->count() }} Listings</span></h1>
					<img class="flag" src="/img/flags/{{ $loc->province }}.jpg" alt="">
					<p>
						{{ $loc->landingPage->description }}
					</p>
					<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="4000">
						@foreach($loc->landingPage->slides as $slide)
							<img class="glmr" src="/img/slides/{{ $slide->name }}" alt="{{ $slide->alt }}">
						@endforeach
					</div>
				</div>
				<div class="right">
					<div class="linksHolder">
						<h2 class="divider">Local Websites</h2>
						<ul>
							@foreach($loc->landingPage->links as $link)
								<li><a target="_blank" href="{{ $link->href }}">{{ $link->title }}</a></li>
							@endforeach
							<div class="cf"></div>
						</ul>
					</div>
					<div class="statsHolder">
						<h2>Statistics</h2>
						<table class="stats">
							@if($housePrice = $loc->averagePrice(\RentGorilla\Rental::HOUSE))
								<tr>
									<td><i class="fa fa-bar-chart"></i> Avg. House Rental Cost</td>
									<td>${{ $housePrice  }}</td>
								</tr>
							@endif
							@if($apartmentPrice = $loc->averagePrice(\RentGorilla\Rental::APARTMENT))
								<tr>
									<td><i class="fa fa-area-chart"></i> Avg. Apartment Cost</td>
									<td>${{ $apartmentPrice  }}</td>
								</tr>
							@endif
							@if($roomPrice = $loc->averagePrice(\RentGorilla\Rental::ROOM))
								<tr>
									<td><i class="fa fa-line-chart"></i> Avg. Room Cost</td>
									<td>${{ $roomPrice }}</td>
								</tr>
							@endif

							@if($monthlySearches = $loc->getMonthlySearches())
								<tr>
									<td><i class="fa fa-pie-chart"></i> Searches for {{ date('F') }}</td>
									<td>{{ $monthlySearches }}</td>
								</tr>
							@endif
						</table>
					</div>
				</div>
				<span id="closeMe"><i class="fa fa-close"></i></span>
			</div>
			<span class="cf"></span>
		</section>
	</section>
	@endif
    <section class="content full">
        <h1 class="resultsNum">{{ $total }} {{ $total == 1 ? 'result' : 'results' }}</h1>
            {!! Form::select('sort', Config::get('sort'), Session::get('sort') ?: 'edited_at-DESC', ['class' => 'sort', 'id' => 'sort-widget', 'title' => 'Sort your results']) !!}
     <div class="cf"></div>
    </section>
    <script>
    	$(".showButton").click(function(){

			$.ajax({
				type: 'POST',
				url: '/landing-page/delete-cookie'
			});

			$('.localeNew').toggleClass('open');
			$('.localeNew').toggleClass('closed');
    	});
    	$("#closeMe").click(function(){

			$.ajax({
				type: 'POST',
				url: '/landing-page/set-cookie'
			});

			$('.localeNew').toggleClass('open');
			$('.localeNew').toggleClass('closed');
    	});
    </script>
    <ul id="rental-list">
        @include('app.rental-list-hits-partial')
    </ul>
@else
    <h1>Sorry, we couldn't find anything matching your search.</h1>
@endif