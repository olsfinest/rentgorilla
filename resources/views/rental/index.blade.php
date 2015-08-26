@extends('layouts.admin')
@section('content')
    <section class="content full admin rentals">
        <section class="my_properties">
            <div class="heading">
                <h1>Your Properties</h1>
				<span class="showing">
					Showing <a href="#">All Listings <span>{{ $rentals->count() }}</span></a>
				</span>
                <span class="cf"></span>
            </div>
            @if($rentals->count())
            @foreach($rentals as $rental)
                <article class="property"> <!-- article.property - 1 per listing -->
                <h1>{{ $rental->street_address }}<span class="neighborhood">{{ $rental->location->city . ', ' . $rental->location->province }}</span></h1>
                <nav>
                    <ul>
                        <li><a class="preview" href="{{ route('rental.preview', $rental->uuid) }}">Preview</a></li>
                        <li><a id="{{ $rental->uuid }}" class="activity {!! $rental->isActive() ? 'on' : 'off' !!}">{!! $rental->isActive() ? 'Active' : 'Inactive' !!}</a></li>
                    </ul>
                </nav>
                <section class="overview">
                    <a href="{{ route('rental.photos.index', $rental->uuid) }}"  class="btn btn-primary">
                        <section class="photos cycle-slideshow">
                            @if($rental->photos->count())
                                @foreach($rental->photos as $photo)
                                    <img src="{{ $photo->getSize('small') }}" alt="">
                                @endforeach
                            @else
                                <img src="{{ getNoPhoto('small') }}" alt="">
                            @endif
                                <span class="photos-title">
                                Photos [{{ $rental->photos->count() }}]
                            </span>
                        </section>
                    </a>
                    <table>
                        <tr>
                            <td><span class="fa fa-dollar"></span>Monthly Rent</td>
                            <td>${{ $rental->price }} per month</td>
                        </tr>
                        <tr>
                            <td><span class="fa fa-calendar"></span>Date Available</td>
                            <td>{{ $rental->available_at->format('M jS, Y') }}</td>
                        </tr>
                        <tr>
                            <td><span class="fa fa-refresh"></span>Last updated:</td>
                            <td>{{ $rental->edited_at->diffForHumans() }}</td>
                        </tr>
                        <tr>
                            <td><span class="fa fa-arrow-up"></span>Promotion</td>
                            @if($rental->isQueued())
                                <td>Starts in approx {{ $rental->getNextAvailablePromotionDays() }} day(s)</td>
                            @elseif($rental->isPromoted())
                                <td>{{ $rental->getPromotedDaysRemaining() }} remaining</td>
                            @else
                                <td>Not promoted</td>
                            @endif
                        </tr>
                    </table>
                    <ul class="controls">
                        <li><a class="edit" href="{{ route('rental.edit', $rental->uuid) }}"><span class="fa fa-edit"></span>Edit</a></li>
                        @if($rental->isQueued())
                            <li><a class="promote" href="{{ route('promotions.cancel', $rental->uuid) }}"><span class="fa fa-arrow-up"></span>Cancel</a></li>
                        @elseif($rental->isPromoted())
                            <li><a class="promote" href="#"><span class="fa fa-arrow-up"></span>Promoted</a></li>
                        @else
                            <li><a class="promote" href="{{ route('promotions', $rental->uuid) }}"><span class="fa fa-arrow-up"></span>Promote</a></li>
                        @endif
                        <li><a class="delete" href="{{ route('rental.delete', $rental->uuid) }}"><span class="fa fa-trash"></span>Delete</a></li>
                    </ul>
                    <ul class="stats">
                        <li>
                            {{ $rental->search_views }}
							<span>
								Search Views
							</span>
                        </li>
                        <li>
                            {{ $rental->views }}
							<span>
								Property Views
							</span>
                        </li>
                        <li>
                            {{ $rental->favouritedBy->count() }}
							<span>
								Times Favourited
							</span>
                        </li>
                        <li>
                            {{ $rental->likes->count() }}
							<span>
								Total Photo Likes
							</span>
                        </li>
                        <li>
                            {{ $rental->email_click }}
							<span>
								Total Email Clicks
							</span>
                        </li>
                        <li>
                            {{ $rental->phone_click }}
                            <span>
								Total Phone Calls
							</span>
                        </li>
                    </ul>
                </section>
            </article><!-- end individual property -->
            @endforeach
            @else
                <p>You have no properties at this time.</p>
            @endif
        </section>
        <!-- sidebar begins -->
        <aside class="my_properties">

            <!-- Plan overview - shows current plan info to the logged-in user -->
            <h3>Plan Overview </h3>
            <section class="widget">
                <table>

                    @if($plan && Auth::user()->subscribed())
                        <tr>
                            <th colspan="2">{{ $plan->planName() }}<a href="{{ route('changePlan') }}">Change</a></th>
                        </tr>
                        <tr>
                            <td>Plan Capacity</td>
                            <td>{{ $plan->maximumListings() }} Active</td>
                        </tr>
                        <tr>
                            <td>Currently Active</td>
                            <td><span id="activeRentalCount">{{ $activeRentalCount }}</span></td>
                        </tr>
                        <tr>
                            <td>Cost Per Month</td>
                            <td>{{ $plan->getPriceWithTax(true) }} per month</td>
                        </tr>
                        <tr>
                            <td>Billing Period</td>
                            <td>{{ $plan->intervalSuffix() }}</td>
                        </tr>
                        <tr>
                            <td>Plan Expiry:</td>
                            <td>{{ Auth::user()->getCurrentPeriodEnd()->format('M jS, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Auto renew:</td>
                            <td>{{ Auth::user()->stripeIsActive() ? 'Yes' : 'No' }}</td>
                        </tr>

                    @elseif(Auth::user()->onTrial())
                        <tr>
                            <th colspan="2">Free Trial<a href="{{ route('changePlan') }}">Change</a></th>
                        </tr>
                        <tr>
                            <td>Plan Capacity</td>
                            <td>Unlimited Properties</td>
                        </tr>
                        <tr>
                            <td>Currently Active</td>
                            <td><span id="activeRentalCount">{{ $activeRentalCount }}</span></td>
                        </tr>
                        <tr>
                            <td>Cost Per Month</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <td>Billing Period</td>
                            <td>n/a</td>
                        </tr>
                        <tr>
                            <td>Plan Expiry:</td>
                            <td>{{ Auth::user()->trial_ends_at->format('M jS, Y') }}</td>
                        </tr>

                    @elseif(Auth::user()->isOnFreePlan())
                        <tr>
                            <th colspan="2">Free Plan<a href="{{ route('changePlan') }}">Change</a></th>
                        </tr>
                        <tr>
                            <td>Plan Capacity</td>
                            <td>1 Active</td>
                        </tr>
                        <tr>
                            <td>Currently Active</td>
                            <td><span id="activeRentalCount">{{ $activeRentalCount }}</span></td>
                        </tr>
                        <tr>
                            <td>Cost Per Month</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <td>Billing Period</td>
                            <td>n/a</td>
                        </tr>
                        <tr>
                            <td>Plan Expiry:</td>
                            <td>{{ Auth::user()->getFreePlanExpiryDate()->format('M jS, Y') }}</td>
                        </tr>
                    @else
                        <tr>
                           <p>You are currently not on any plan.</p>
                        </tr>
                        <tr>
                            <a class="property-add" href="{{ route('changePlan') }}"><span class="fa fa-plus"></span> Sign Up</a>
                    </tr>
                       @endif
                </table>
            </section>
            <!-- add a property button - this can be changed to an actual button element if necessary -->
            <h3>Add New Property</h3>
            <a class="property-add" href="{{ route('rental.create') }}"><span class="fa fa-plus"></span> Add a New Property</a>
            <!-- achievements / gamification -->
            <h3>Achievements</h3>
            <section class="widget">
                <table>
                    <tr>
                        <th colspan="2">Completed Badges</th>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="Complete 100% of all fields in your property profile, required and optional. This includes a photo and website address. Don't have a website address? Register one with us, or simply enter 'rentgorilla.com'"></span>Complete Profile</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::COMPLETE_PROFILE, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="Each of your listings has never exceeded 30 days without an update."></span>Current Listings</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::CURRENT_LISTINGS, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="You maintain at least 10 photos across 2 or more properties."></span>Lots of Photos</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::LOTS_OF_PHOTOS, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="You have promoted any combination of properties at least twice a month."></span>Power Promoter</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::POWER_PROMOTER, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="You have an active listing for a total of 365 days. This is easiest to achieve by simply modifying your date of availability."></span>Rent Gorilla</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::RENT_GORILLA, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="Any combination of photos have received at least 20 likes."></span>Great Photos</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::GREAT_PHOTOS, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                    <tr>
                        <td><span class="fa fa-question-circle" title="You have added links to at least two videos for any combination of properties and those videos have received at least 20 likes."></span>Movie Star</td>
                        <td><span class="fa {{ in_array(\RentGorilla\Rewards\Achievement::MOVIE_STAR, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                    </tr>
                </table>
            </section>
        </aside>
        <div class="cf"></div>
    </section>
@stop
@section('footer')
<script src="/js/settings-rental-list.js"></script>
<script src="/js/cycle.js"></script>
@stop




