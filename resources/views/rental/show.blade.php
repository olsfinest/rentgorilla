@extends('layouts.app')
@section('content')
@include('partials.header')


<section style="display: none" id="email-manager">
    <h1>Email Property Manager</h1><br>
    <div id="email-manager-form-errors"></div><br>
    {!! Form::open(['route' => 'rental.email', 'id' => 'email-manager-form']) !!}
    <input type="text" id="email-manager-fname" name="fname" placeholder="First name">
    <input type="text" id="email-manager-lname" name="lname" placeholder="last name"><br>
    <input type="email" id="email-manager-email" name="email" placeholder="Your email address"><br>
    <input type="hidden" name="rental_id" value="{{ $rental->uuid }}">
    <textarea id="email-manager-message" name="message" placeholder="Write message here"></textarea><br>
    <input type="submit" value="Send Message">
    {!! Form::close() !!}
</section>

<section class="listing_nav">
    <section class="main">
        <a class="back" href="">< Back</a><a class="forward" href="#">Next Listing ></a>
    </section>
</section>
<section class="main">
    <section class="content full">
        <section class="listing_meta">
			<span class="listing_neighborhood">
				<h1>{{ $rental->street_address }}</h1>
				<h2>{{ $rental->city . ', ' . Config::get('rentals.provinces.' . $rental->province) }}</h2>
			</span>
			<span class="listing_availability">
				<h1>Available {{ $rental->available_at->format('F j, Y') }}</h1>
				<h2>Last updated: {{ $rental->updated_at->diffForHumans() }}</h2>
			</span>
            <div class="cf"></div>
        </section>
        <article class="listing_details">
            <section class="listing_overview">
                <div id="photos" class="listing_image cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="5000">
                    <img src="/img/listing_image_01.jpg" alt="">
                    <img src="/img/listing_image_01.jpg" alt="">
                    <img src="/img/listing_image_01.jpg" alt="">

                    <h3>{{ $rental->beds }} Bedroom / {{ $rental->baths }} Bathroom {{ Config::get('rentals.type.' . $rental->type) }}</h3>
                    <span id="{{ $rental->uuid }}" class="favourite fa {{ in_array($rental->id, $favourites) ? 'fa-heart' : 'fa-heart-o' }}">{{ $rental->favouritedBy()->count() }}</span>
                </div>
                <div id="map" style="width:100%; height:468px !important; display: none"></div>
                <div class="listing_view_controls">
                    <ul class="justified">
                        <li><a id="photos-btn">Photos</a></li>
                        <li><a id="street-view-btn">Street View</a></li>
                        <li><a id="map-btn">Map</a></li>
                    </ul>
                </div>
            </section>
            <h3 class="listing_ng_title">The Nitty Gritty</h3>
            <a href="#" class="fa fa-share-square-o share"><span>Share</span></a>
            <span class="cf"></span>
            <table class="listing_ng">
                <tr>
                    <td class="listing_ng_label">Lease</td>
                    <td>{{ $rental->lease ? 'Yes, ' . $rental->lease . ' months' : 'No' }}</td>
                    <td class="listing_ng_label">Smoking</td>
                    <td>{{ $rental->smoking ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Deposit</td>
                    <td>{{ $rental->deposit ? '$' . $rental->deposit : 'No' }}</td>
                    <td class="listing_ng_label">Utilities</td>
                    <td>{{ $rental->utilites_included ? 'Included' : 'Not included' }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Pets</td>
                    <td>{{ Config::get('rentals.pets.' . $rental->pets) }}
                    <td class="listing_ng_label">Furnished</td>
                    <td>{{ $rental->furnished ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Parking</td>
                    <td>{{ Config::get('rentals.parking.' . $rental->parking) }}</td>
                    <td class="listing_ng_label">Appliances</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Laundry</td>
                    <td>{{ Config::get('rentals.laundry.' . $rental->laundry) }}</td>
                    <td class="listing_ng_label">Heat Type</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Disability Access</td>
                    <td>{{ $rental->disability_access ? 'Yes' : 'No' }}</td>
                    <td class="listing_ng_label">Heat Included</td>
                    <td>{{ $rental->heat_included ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </article>
        <aside class="listing_sidebar">
            <section class="listing_rent">
                <h1>${{ $rental->price }} per month</h1>

                <h3><a href="#">Contact Now</a></h3>

                <ul class="listing_contact">
                    <li><a class="phone-btn" id="{{ $rental->uuid }}" href="#">Show Phone Number</a></li>
                    <li><a class="email-manager-btn" id="{{ $rental->uuid }}" href="#">Email Property Manager</a></li>
                </ul>

                @if(count($rental->features))
                    <h3>Best Features</h3>
                    <table class="listing_features">
                        @foreach(array_chunk($rental->features->all(), 2) as $column)
                        <tr>
                            @foreach($column as $feature)
                                <td>{{ $feature->name }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </table>
                @endif
                <h3>Property Size</h3>

                <ul class="justified">
                    <li><a href="#">{{ $rental->square_footage }} SqFt</a></li>
                    <li><a href="#">${{ $rental->pricePerSquareFoot() }} / SqFt</a></li>
                </ul>

                <h3>Description</h3>

                <p>
                    {{ $rental->description }}
                </p>

                @if($count = $rental->user->rentals->count() - 1)

                    <h3>More Properties</h3>

                    <a href="#">From This Property Manager ({{ $count }})</a>
                    <ul>
                    @foreach ($rental->user->rentals as $managersProperty)
                        @if($rental->id != $managersProperty->id)
                            <li><a href="{{ route('rental.show', [$managersProperty->uuid]) }}">{{ $managersProperty->getAddress() }}</a></li>
                        @endif
                    @endforeach
                    </ul>
                @endif

            </section>
        </aside>
        <div class="cf"></div>
    </section>
</section>
@endsection

@section('footer')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/cycle.js"></script>
    <script src="/js/detail-view.js"></script>
    <script language="JavaScript">
        var initialPosition = new google.maps.LatLng({{ $rental->lat . ', ' . $rental->lng  }});
        var panorama;
        var map;
        var marker;
        var streetViewService = new google.maps.StreetViewService();
        var SVW_MAX=100;
        var SVW_INC=0;

        function loadMap()	{

            var mapOptions = {
                center: initialPosition,
                zoom: 15,
                streetViewControl: false

            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            marker = new google.maps.Marker({position:initialPosition, map:map, title:'' });

            panorama = map.getStreetView();
            panorama.setPosition(initialPosition);
            resolveStreetView(initialPosition, SVW_INC);


            // Resize stuff...
            google.maps.event.addDomListener(window, "resize", function() {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(center);
            });
        }

        function resolveStreetView(initialPosition,streetViewMaxDistance) {

            streetViewService.getPanoramaByLocation(initialPosition, streetViewMaxDistance, function (streetViewPanoramaData, status) {

                if(status === google.maps.StreetViewStatus.OK){
                    var heading = google.maps.geometry.spherical.computeHeading(streetViewPanoramaData.location.latLng,initialPosition);
                    panorama.setPosition(initialPosition);
                    panorama.setPov({
                        heading: heading,
                        zoom: 1,
                        pitch: 0
                    });
                } else if(svwdst<SVW_MAX) {
                    resolveStreetView(initialPosition,svwdst+SVW_INC);
                }
            });
        }

    $('#photos-btn').on('click', function() {
        $('#map').hide();
        $('#photos').show();
    });

    $('#map-btn').on('click', function() {
        $('#photos').hide();
        $('#map').show();
        loadMap();
        panorama.setVisible(false);
    });

    $('#street-view-btn').on('click', function() {
        $('#photos').hide();
        $('#map').show();
        loadMap();
        panorama.setVisible(true);
    });


        $(document).ready(function() {
            $(".cycle-slideshow").cycle();
        });

</script>

@endsection