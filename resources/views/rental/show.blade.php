@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/login.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/form.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('content')
@include('partials.header')


<section class="modalLogin" id="email-manager">
    {!! Form::open(['route' => 'rental.email', 'id' => 'email-manager-form']) !!}
    <a class="modalClose" title="Close">x</a>
    <h1>Email Property Manager</h1>
    <h4>
        <strong>{{ $rental->user->getFullName() }}</strong>
        {{ $rental->getAddress() }}
    </h4>
    <div id="email-manager-form-errors"></div><br>
    <label for="" class="half left">
        <input type="text" name="fname" placeholder="First Name" tabindex="4">
    </label>
    <label for="" class="half right">
        <input type="text" name="lname" placeholder="Last Name" tabindex="5">
    </label>
    <label for="email">
        <input placeholder="Your email address" type="email" name="email" value="" tabindex="6">
    </label>
    <label for="message">
        <textarea name="message" id="" cols="30" rows="10" placeholder="Your message to the property manager" tabindex="7"></textarea>
    </label>
    <input type="hidden" name="rental_id" value="{{ $rental->uuid }}">
    <input placeholder="" type="submit" name="submit" value="Send" tabindex="8">
    {!! Form::close() !!}
</section>

<section class="listing_nav">
    <section class="main">
        @if($previous)
        <a class="back" href="{{ route('rental.show', [$previous]) }}"> &laquo; Previous Listing</a>
        @endif
        @if($next)
        <a class="forward" href="{{ route('rental.show', [$next]) }}">Next Listing &raquo;</a>
        @endif
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
				<h2>Last updated: {{ $rental->edited_at->diffForHumans() }}</h2>
			</span>
            <div class="cf"></div>
        </section>
        <article class="listing_details">
            <section class="listing_overview" style="position: relative;">
                <div id="photos" class="listing_image cycle-slideshow" data-cycle-pause-on-hover="true" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="5000">
                    @if($rental->isPromoted())
                        <span class="promoted"></span>
                    @endif
                    <span id="like" class="fa fa-thumbs-o-up"></span>
                    @if($hasPhotos = count($rental->photos))
                        @foreach($rental->photos as $photo)
                            <img id="{{ $photo->id }}" class="{{ in_array($photo->id, $likes) ? 'liked' : '' }}" src="{{ $photo->getSize('medium') }}">
                        @endforeach
                    @else
                        <img src="{{ getNoPhoto('medium') }}">
                    @endif
                    <h3>{{ $rental->beds }} Bedroom / {{ $rental->baths }} Bathroom {{ Config::get('rentals.type.' . $rental->type) }}</h3>
                    <span id="favourite" class="favourite fa {{ in_array($rental->id, $favourites) ? 'fa-heart' : 'fa-heart-o' }}">{{ $rental->favouritedBy()->count() }}</span>
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
           <span id="share" style="width: 150px; float: right;">
	<i class="fa fa-share-square-o"></i> Share Page
	<ul>
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('rental.show', $rental->uuid) }}" target="_blank" title="Share on Facebook">
                <i class="fa fa-facebook"></i>
                Facebook
            </a>
        </li>
        <li>
            <a href="http://twitter.com/home?status={{ route('rental.show', $rental->uuid) . ' ' . $rental->getAddress() }}" target="_blank" title="Share on Twitter">
                <i class="fa fa-twitter"></i>
                Twitter
            </a>
        </li>
        <li>
            <a href="mailto:?subject=RentGorilla&amp;body=I thought you might be interested in this Rental listing: {{ route('rental.show', $rental->uuid) . ' ' . $rental->getAddress() }}" target="_blank" title="Share by Email">
                <i class="fa fa-envelope"></i>
                Email
            </a>
        </li>
    </ul>
</span>
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
                    <td class="tooltipable" title="{{ $appliances = implode(', ', $rental->appliances()->lists('name')) }}">{{ str_limit($appliances, 17) }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">Laundry</td>
                    <td>{{ Config::get('rentals.laundry.' . $rental->laundry) }}</td>
                    <td class="listing_ng_label">Heat Type</td>
                    <td class="tooltipable" title="{{ $heat = implode(', ', $rental->heat()->lists('name')) }}">{{ str_limit($heat, 17) }}</td>
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
                    <li><a id="phone-btn">Show Phone Number</a></li>
                    <li><a id="email-manager-btn">Email Property Manager</a></li>
                </ul>
                @if( ! is_null($rental->video))
                <h3><a href="#">Video</a></h3>
                     <ul class="listing_contact">
                        <li><a id="show_video">Play Video</a></li>
                </ul>
                @endif

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

            </section>
        </aside>
        <div class="cf"></div>
    </section>
</section>
@endsection

@section('footer')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/cycle.js"></script>
    <script language="JavaScript">
        var rental_id = "{{ $rental->uuid }}";
        var hasPhotos = {{ $hasPhotos ? 'true' : 'false' }}
    </script>
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

            if(hasPhotos) {
                $(".cycle-slideshow").cycle();

                $(".cycle-slideshow").hover(function () {
                    $('#like').show();
                }, function () {
                    $('#like').hide();
                });

                $(".cycle-slideshow").on('cycle-update-view', function (event, optionHash, slideOptionsHash, currentSlideEl) {
                    var slide = $(currentSlideEl);
                    $('#like').data('photo_id', slide.attr('id'));
                    if (slide.hasClass('liked')) {
                        $('#like').removeClass('fa-thumbs-o-up');
                        $('#like').addClass('fa-thumbs-up');
                    } else {
                        $('#like').removeClass('fa-thumbs-up');
                        $('#like').addClass('fa-thumbs-o-up');
                    }
                });
            }

            $(".tooltipable").hover(function(){
                $(this).tooltip({position:{my:"center bottom",at:"left top"}});
            });

            $( ".modalClose").on('click', function() {
                var $dialog = $(this).parents('.ui-dialog-content');
                $dialog.dialog('close');
            });

        });


</script>

@endsection