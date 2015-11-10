@extends('layouts.admin')
@section('content')
    <section class="promotedCta">
        <section class="content full closer">
            <span class="fa fa-close" title="Close this notification"></span>
        </section>
        <section class="content full">
            <p>There are currently 2 promoted property slots available in your area. <span style="text-decoration:underline;">Promote Your Property Below.</span></p>
        </section>
    </section>
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
                                Edit Photos [{{ $rental->photos->count() }}]
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
                                <td>Queued</td>
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
            <!-- add a property button - this can be changed to an actual button element if necessary -->
            <h3><i title="Adding a property does not cost you anything. Only upgrading your subscription or promoting a property incurs a bill." class="fa fa-info-circle"></i> Add New Property</h3>
            <a class="property-add" href="{{ route('rental.create') }}">
                <i class="fa fa-home"></i><br/>
                <span class="fa fa-plus"></span> Add a New Property
            </a>
            <p>
                <small></small>
            </p>
            
            <!-- Plan overview - shows current plan info to the logged-in user -->
            <h3>Plan Overview </h3>

            <section class="widget plan">
            <table>
            @if(Auth::user()->onTrial())
                <tr>
                    <th colspan="2">Free Trial<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
                </tr>
                <tr>
                    <td>
                        Free Trial Listings Capacity
                        <div class="planStats">
                            <!-- {{ $plan->maximumListings() }} -->
                        </div>
                    </td>
                    <td>
                        Currently Active Listings
                        <div class="planStats">
                            <!-- <span id="activeRentalCount">{{ $activeRentalCount }}</span> -->
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cost Per {{ $plan->intervalSuffix() }}
                        <div class="planStats">
                            {{ $plan->getPriceWithTax(true) }}<small>00</small>
                        </div>
                    </td>
                    <td class="planDateMonth">
                        Plan Expiry
                        <div class="planStats">
                            {{ Auth::user()->trial_ends_at->format('M jS, Y') }}
                            <!-- <span class="month">December</span><span class="day">12</span> -->
                        </div>
                    </td>
                </tr>
            @elseif($plan && (Auth::user()->stripeIsActive() || Auth::user()->onGracePeriod()))
                <tr>
                    <th colspan="2">{{ $plan->planName() }}<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
                </tr>
                <tr>
                    <td>
                        {{ $plan->planName() }} Listings Capacity
                        <div class="planStats">
                            {{ $plan->maximumListings() }}
                        </div>
                    </td>
                    <td>
                        Currently Active Listings
                        <div class="planStats">
                            <span id="activeRentalCount">{{ $activeRentalCount }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cost Per {{ $plan->intervalSuffix() }}
                        <div class="planStats">
                            {{ $plan->getPriceWithTax(true) }}.<small>00</small>
                        </div>
                    </td>
                    <td class="planDateMonth">
                        Plan Expiry
                        <div class="planStats">
                            {{ Auth::user()->getCurrentPeriodEnd()->format('M jS, Y') }}
                            <!-- <span class="month">December</span><span class="day">12</span> -->
                        </div>
                    </td>
                </tr>
            @elseif(Auth::user()->isOnFreePlan())
                <tr>
                    <th colspan="2">Free Plan<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
                </tr>
                <tr>
                    <td>
                        Free Plan Listings Capacity
                        <div class="planStats">
                            1
                        </div>
                    </td>
                    <td>
                        Currently Active Listings
                        <div class="planStats">
                            <span id="activeRentalCount">{{ $activeRentalCount }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cost Per Month
                        <div class="planStats">
                            $0
                        </div>
                    </td>
                    <td class="planDateMonth">
                        Plan Expiry
                        <div class="planStats">
                            <!-- {{ Auth::user()->getFreePlanExpiryDate()->format('M jS, Y') }} -->
                            <span class="month">{{ Auth::user()->getFreePlanExpiryDate()->format('F') }}</span><span class="day">{{ Auth::user()->getFreePlanExpiryDate()->format('jS') }}</span>
                        </div>
                    </td>
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
            <!--
            <section class="widget">
                <table>

                    @if(Auth::user()->onTrial())
                        <tr>
                            <th colspan="2">Free Trial<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
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

                    @elseif($plan && (Auth::user()->stripeIsActive() || Auth::user()->onGracePeriod()))
                        <tr>
                            <th colspan="2">{{ $plan->planName() }}<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
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
                            <td></td>
                        </tr>
                        <tr>
                            <td>Plan Expiry:</td>
                            <td>{{ Auth::user()->getCurrentPeriodEnd()->format('M jS, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Auto renew:</td>
                            <td>{{ Auth::user()->stripeIsActive() ? 'Yes' : 'No' }}</td>
                        </tr>


                    @elseif(Auth::user()->isOnFreePlan())
                        <tr>
                            <th colspan="2">Free Plan<a class="planChange" href="{{ route('changePlan') }}">Change</a></th>
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
            -->
            <!-- achievements / gamification -->
            <h3>Achievements</h3>
            <section class="widget">
                <table class="achievementsTable">
                    <tr>
                        <th colspan="2">Completed Badges</th>
                    </tr>
                    @foreach(Config::get('rewards') as $reward => $rewardProps)
                        <tr>
                            <td title="{{ $rewardProps['description'] }} ({{ $rewardProps['points'] . ($rewardProps['monthly'] ? ' points/month' : ' points') }})"><span class="fa fa-question-circle"></span> {{ $rewardProps['name'] }}</td>
                            <td><span class="fa {{ in_array($reward, $rewards) ? 'fa-star' : 'fa-star-o' }}"></span></td>
                        </tr>
                    @endforeach
                </table>
            </section>
            <p>Badges are awarded at 12:00AM AT</p>
        </aside>
        <div class="cf"></div>
    </section>
@stop
@section('footer')
<script src="/js/settings-rental-list.js"></script>
<script src="/js/cycle.js"></script>
<script>
    $('.fa-close').click(function(){
        // close the nearest instance of .promotedCta when clicking on the close button
        $(this).closest('.promotedCta').hide();
        // also remove the hilite class from the promote buttons
        $('.promote').removeClass('hilite');
    });
    $('.promotedCta .content p').click(function(){
        // add a class to the promote buttons to animate the arrow and darken the background
        $('.promote').addClass('hilite');
    });
</script>
@stop