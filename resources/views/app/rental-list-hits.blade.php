
@if($rentals->count())
	<section class="localeNew open">
		<section class="content full">
			<h2 class="showButton">View Community Profile, Links &amp; Statistics</h2>

			<div class="showMe">
				<div class="left">
					<h1>Antigonish <span>{{ $total }} Listings</span></h1>
					<img class="flag" src="/img/flags/NS.jpg" alt="">
					<p>
						Antigonish (Scottish Gaelic: Am Baile Mor) is a Canadian town in Antigonish County, Nova Scotia. The Town is home to St. Francis Xavier University and the oldest continuous Highland Games outside of Scotland. It is approximately one hundred miles (161km) northeast of Halifax.
					</p>
                	<img class="glmr" src="https://rentgorilla.ca/img/slides/rD4yjOqCW0Kd.jpeg" alt="">
				</div>
				<div class="right">
					<h2 class="divider">Local Websites</h2>
					<ul>
						<li><a href="http://stfx.ca">St. Francis Xavier University</a></li>
						<li><a href="#">Theatre Antigonish</a></li>
						<li><a href="#">The Town of Antigonish</a></li>
						<li><a href="#">The County of Antigonish</a></li>
						<li><a href="#">Antigonish Mall</a></li>
						<li><a href="#">Awesome Antigonish</a></li>
						<div class="cf"></div>
					</ul>
					<h2>Statistics</h2>
					<table>
						<tr>
							<td>Avg. House Rental Cost</td>
							<td>$1408.00</td>
						</tr>
						<tr>
							<td>Avg. Apartment Cost</td>
							<td>$906.17</td>
						</tr>
						<tr>
							<td>Avg. Room Cost</td>
							<td>$856.75</td>
						</tr>
						<tr>
							<td>Searches for November</td>
							<td>570</td>
						</tr>
					</table>
				</div>
				<span id="closeMe"><i class="fa fa-close"></i></span>
			</div>
			<span class="cf"></span>
		</section>
	</section>
    <section class="content full">
        <h1 class="resultsNum">{{ $total }} {{ $total == 1 ? 'result' : 'results' }}</h1>
            {!! Form::select('sort', Config::get('sort'), Session::get('sort') ?: 'available_at-ASC', ['class' => 'sort', 'id' => 'sort-widget', 'title' => 'Sort your results']) !!}
     <div class="cf"></div>
    </section>
    <script>
    	$(".showButton").click(function(){
    		$('.showMe').fadeIn(50, "swing");
    		$(this).fadeOut(50, "swing");
    	});
    	$("#closeMe").click(function(){
    		$('.showMe').fadeOut(50, "swing");
    		$('.showButton').fadeIn(50, "swing");
    	});
    </script>
    <ul id="rental-list">
        @include('app.rental-list-hits-partial')
    </ul>
@else
    <h1>Sorry, we couldn't find anything matching your search.</h1>
@endif