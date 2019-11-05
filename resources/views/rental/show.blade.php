@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/login.css?v=2" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/form.css?v=2" media="screen" title="no title" charset="utf-8">
    @include('rental.twitter-summary-large-image')
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
        @if($searchResultsBtn)
            <a class="back" href="{{ route('list', [$rental->location->slug, 'page' => session('page', 1)]) }}">&laquo; Back to Search Results</a>
        @else
            <a class="back" href="{{ route('rental.index') }}">&laquo; Back to Dashboard</a>
        @endif
        @if($next)
            <a class="forward" href="{{ route('rental.show', [$next]) }}">Next &raquo;</a>
        @endif
        @if($previous)
            <a class="forward" href="{{ route('rental.show', [$previous]) }}"> &laquo; Previous</a>
        @endif
    </section>
</section>
<section class="main">
    <section class="content full">
        <section class="listing_meta">
			<span class="listing_neighborhood">
				<h1>{{ $rental->street_address }} <i><small>{{ $rental->apartment }}</small></i></h1>
				<h2>{{ $rental->location->city . ', ' . Config::get('rentals.provinces.' . $rental->location->province) }}</h2>
			</span>
			<span class="listing_availability">
				<h1>{{ $rental->available_at->format('F j, Y') }} <i class="fa fa-calendar"></i></h1>
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
                    @if($hasPhotos = $rental->photos()->count())
                        @foreach($rental->photos as $photo)
                            <img id="{{ $photo->id }}" class="{{ in_array($photo->id, $likes) ? 'liked' : '' }}" src="{{ $photo->getSize('medium') }}">
                        @endforeach
                    @else
                        @foreach($noPhotos->shuffle() as $noPhoto)
                            <img src="{{ $noPhoto }}" usemap="#Map">
                        @endforeach
                            <map name="Map" id="Map">
                                <area target="_blank" shape="rect" coords="400,330,600,385" href="https://gorillafund.org/donate/rentgorilla" alt="Donate" />
                            </map>
                    @endif
                    <h3>{{ $rental->beds }} Bedroom / {{ (float) $rental->baths }} Bathroom {{ Config::get('rentals.type.' . $rental->type) }}</h3>
                    <span id="favourite" class="favourite fa {{ in_array($rental->id, $favourites) ? 'fa-heart' : 'fa-heart-o' }}">{{ $rental->favouritedBy()->count() }}</span>
                    <span class="cycle-prev"></span>
                    <span class="cycle-next"></span>
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
            <h3 class="listing_ng_title">Property Details</h3>
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
                    <td class="listing_ng_label">
                        <i class="fa fa-file-text-o"></i>
                        Lease
                    </td>
                    <td>{{ $rental->lease ? 'Yes, ' . $rental->lease . ' months' : 'No' }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-fire"></i>
                        Smoking
                    </td>
                    <td>{{ $rental->smoking ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-dollar"></i>
                        Deposit
                    </td>
                    <td>{{ $rental->deposit ? '$' . $rental->deposit : 'No' }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-lightbulb-o"></i>
                        Utilities
                    </td>
                    
					  <td class="tooltipable" title="{{ $utility = implode(', ', $rental->utility()->lists('name')->all()) }}">{{ str_limit($utility, 17) }}</td>
					
					
                </tr>
                <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-paw"></i>
                        Pets
                    </td>
                    <td>{{ Config::get('rentals.pets.' . $rental->pets) }}
                    <td class="listing_ng_label">
                        <i class="fa fa-bed"></i>
                        Furnished
                    </td>
                    <td> 
					{{ $rental->furnished }}  </td>
                </tr>
                <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-car"></i>
                        Parking
                    </td>
                    <td>{{ Config::get('rentals.parking.' . $rental->parking) }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-television"></i>
                        Appliances
                    </td>
                    <td class="tooltipable" title="{{ $appliances = implode(', ', $rental->appliances()->lists('name')->all()) }}">{{ str_limit($appliances, 17) }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-refresh"></i>
                        Laundry
                    </td>
                    <td>{{ Config::get('rentals.laundry.' . $rental->laundry) }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-fire"></i>
                        Heat Type
                    </td>
                    <td class="tooltipable" title="{{ $heat = implode(', ', $rental->heat()->lists('name')->all()) }}">{{ str_limit($heat, 17) }}</td>
                </tr>
                <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-wheelchair"></i>
                        <!-- Disability Access -->
                        Accesible
                    </td>
                    <td>{{ $rental->disability_access ? 'Yes' : 'No' }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-pause-circle"></i>
                        Services
                    </td>
                    <td class="tooltipable" title="{{ $services = implode(', ', $rental->services()->lists('name')->all()) }}">{{ str_limit($services, 17) }}</td>
                </tr>
				 <tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-share-square-o"></i>
                        <!-- Disability Access -->
                        Flooring
                    </td>
                    <td>{{ $rental->floors }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-hospital-o"></i>
                        Safety and Security
                    </td>
                    <td class="tooltipable" title="{{ $safeties = implode(', ', $rental->safeties()->lists('name')->all()) }}">{{ str_limit($safeties, 17) }}</td>
                </tr>
				<tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-calendar-o"></i>
                        <!-- Disability Access -->
                        Year of Construction
                    </td>
                    <td>{{ $rental->yearofconstruction }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-calendar-o"></i>
                        Year of Renovation
                    </td>
                    <td>{{ $rental->yearofrenovation }}</td>
                </tr>
				<tr>
                    <td class="listing_ng_label">
                        <i class="fa fa-hand-pointer-o"></i>
                        <!-- Disability Access -->
                        Occupancy Permit
                    </td>
                    <td>{{ $rental->occupancy_permit  ? 'Yes' : 'No'  }}</td>
                    <td class="listing_ng_label">
                        <i class="fa fa-qrcode"></i>
                        Up To Code
                    </td>
                    <td>{{ $rental->up_to_code   ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </article>
        <aside class="listing_sidebar">
            <section class="listing_rent">
                <h1>${{ $rental->price }} {{ $rental->per_room || $rental->isRoom() ? 'per room' : '' }} per month</h1>

                <h3><a href="#">Contact Now</a></h3>

                <ul class="listing_contact">
                    <li><a id="phone-btn">Show Phone Number</a></li>
                    <li><a class="email-manager-btn">Email Property Manager</a></li>
                </ul>
                @if( ! is_null($rental->video))
                <h3><a href="#">Video</a></h3>
                     <ul class="listing_contact">
                        <li><a id="show_video">Play Video</a></li>
                </ul>
                @endif

            @if($rental->features()->count())
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

                @if( ! is_null($rental->square_footage))
                    <h3>Property Size</h3>

                    <ul class="justified">
                        <li><a href="#">{{ $rental->square_footage }} SqFt</a></li>
                        <li><a href="#">${{ $rental->pricePerSquareFoot() }} / SqFt</a></li>
                    </ul>
                @endif

                @if( ! is_null($rental->description))
                    <h3>Description</h3>
                    <p>
                        {!! nl2br(e($rental->description)) !!}
                    </p>
                @else
                    <br>
                @endif

                <section class="pmp">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Property Manager Profile <span class="toggle"><i class="fa fa-minus"></i></span></th>
                            </tr>
                            @if($company = $rental->user->getProfileItem('company'))
                                <tr>
                                    <td><i class="fa fa-suitcase"></i></td>
                                    <td>{{ $company }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><i class="fa fa-user"></i></td>
                                <td>
                                    {{ $rental->user->getFullName() }}
                                </td>
                            </tr>
                            @if($website = $rental->user->getProfileItem('website'))
                                <tr>
                                    <td><i class="fa fa-globe"></i></td>
                                    <td><a href="{{ $website }}" target="_blank">{{ $website }}</a></td>
                                </tr>
                            @endif
                            @if($rental->user->getProfileItem('accepts_texts'))
                                <tr>
                                  <td>
                                    <i class="fa fa-mobile"></i>
                                  </td>
                                  <td>
                                    Accepts text messages
                                  </td>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                            @if($profilePhoto = $rental->user->getProfilePhoto('large'))
                             <tr>
                              <td>
                                <i class="fa fa-picture-o"></i>
                              </td>
                              <td>
                                <img src="{{ $profilePhoto }}">
                              </td>
                            </tr>
                            @endif
                            @if($bio = $rental->user->getProfileItem('bio'))
                             <tr>
                              <td>
                                <i class="fa fa-file-text"></i>
                              </td>
                              <td>
                                  {!! nl2br(e($bio)) !!}
                              </td>
                            </tr>
                            @endif
                            @if(count($otherRentals))
                                <tr>
                                    <td colspan="2">
                                        <i class="fa fa-list"></i> Other rentals
                                        <ul>
                                            @foreach($otherRentals as $otherRental)
                                                <li><a href="{{ route('rental.show', [$otherRental->uuid]) }}">{{ $otherRental->getAddress() }}</a></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </section>
            </section>
        </aside>
        <div class="cf"></div>
    </section>
</section>
@endsection

@section('footer')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
    <script src="/js/cycle.js"></script>
    <script language="JavaScript">
        var rental_id = "{{ $rental->uuid }}";
        var hasPhotos = {{ $hasPhotos ? 'true' : 'false' }};
    </script>
    <script src="/js/detail-view.js?v=4"></script>
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

            $('.pmp thead').click(function(){
                $('.pmp tbody').toggle("fast", function(){});;
                $('th span i').toggleClass('fa-minus');
                $('th span i').toggleClass('fa-plus');
            });
        });


</script>

@endsection
