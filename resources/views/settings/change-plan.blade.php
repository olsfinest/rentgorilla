
@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/pricing.css">
@stop
@section('content')
    <section class="content full admin pricing">
        <h1>RentGorilla Subscription Pricing</h1>
        <p>
        </p>

        @if(Auth::user()->onTrial())
            <div class="toast">
                <span class="fa fa-close"></span>
                <h1><i class="fa fa-info-circle"></i> Free Trial</h1>
                <p>
                    <strong>Lucky you! You're on a free trial with RentGorilla.</strong><br/>
                    During your trial period ({{  Auth::user()->getTrialEndDate()->diffInDays() }} days remaining) you can list an unlimited number of properties with us.
                    <br/>
                    However, once your trial ends, your account will be limited to 1 listing. At this point, you can continue on with your free account, or purchase a plan below to suit your needs.
                </p>
                <p>Please note that when you purchase a subscription that subscription will begin immediately and your free trial period will end.</p>
                <p>
                    Thanks for listing with RentGorilla!
                </p>
            </div>
        @endif
        <ul id="plans">
            <li>
                <h2>Free Year</h2>
                <span class="quantity"><strong>1</strong> Property</span>
                <span class="price">$0.00</span>
                <span class="terms">Free for 1 property</span>
                @if(Auth::user()->isOnFreePlan())
                    <span class="currentPlan">This is your current plan</span>
                @endif
            </li>
            <li class="focus">
                <h2>Personal Plan <small>Most Popular</small></h2>
                <span class="quantity"><strong>2-5</strong> Properties</span>
                <span class="price">$8.00</span>
                <span class="terms">Billed annually or $10 month-to-month</span>
                {!! Auth::user()->getPlanLink('Personal_Monthly') !!}
                {!! Auth::user()->getPlanLink('Personal_Yearly') !!}
                @if(Auth::user()->isOnActivePlans(['Personal_Monthly', 'Personal_Yearly']))
                    <span class="currentPlan">This is your current plan</span>
                @endif

            </li>
            <li>
                <h2>Professional Plan</h2>
                <span class="quantity"><strong>6-10</strong> Properties</span>
                <span class="price">$16.00</span>
                <span class="terms">Billed annually or $20 month-to-month</span>
                {!! Auth::user()->getPlanLink('Professional_Monthly') !!}
                {!! Auth::user()->getPlanLink('Professional_Yearly') !!}
                @if(Auth::user()->isOnActivePlans(['Professional_Monthly', 'Professional_Yearly']))
                    <span class="currentPlan">This is your current plan</span>
                @endif
            </li>
            <li>
                <h2>Business Plan</h2>
                <span class="quantity"><strong>11+</strong> Properties</span>
                <span class="price">$24.00</span>
                <span class="terms">Billed annually or $30 month-to-month</span>
                {!! Auth::user()->getPlanLink('Business_Monthly') !!}
                {!! Auth::user()->getPlanLink('Business_Yearly') !!}
                @if(Auth::user()->isOnActivePlans(['Business_Monthly', 'Business_Yearly']))
                    <span class="currentPlan">This is your current plan</span>
                @endif
            </li>
            <div class="cf"></div>
        </ul>
    </section>
    <section class="content full pricing">
        <img src="/img/achievements_large.png" alt="" class="align-left">
        <div class="achievements_container">
            <h2>Earn Credit With RentGorilla Achievements</h2>
            <p>
                Earn credit towards your plan with RentGorilla achievements. Each achievement earns you points that you can {!! link_to_route('redeem.show', 'redeem') !!}
            </p>
            <p>
                Some achievements are even awarded monthly!
            </p>
            <table class="achievements_overview">
                <tr>
                    <td>
                        <ul id="achievements_tabs">
                            <li><a href="#complete">Complete Profile</a></li>
                            <li><a href="#current">Current Listings</a></li>
                            <li><a href="#photos">Lots of Photos</a></li>
                            <li><a href="#promoted">Power Promoter</a></li>
                            <li><a href="#rentgorilla">Rent Gorilla</a></li>
                            <li><a href="#favourites">Lots of Favourites</a></li>
                            <li><a href="#star">Movie Star</a></li>
                        </ul>
                    </td>
                    <td>
                        <div id="complete" class="achievement">
                            <h1>Complete Profile - 500 Points / Month</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                Complete 100% of all fields in your property profile, required and optional. This includes a photo, website address. Don’t have a website address, register one with us or just leave rentgorilla.com.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="current" class="achievement">
                            <h1>Current Listings - 1000 Points / Month</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                Each of your listings has never exceeded 30 days without an update.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="photos" class="achievement">
                            <h1>Lots of Photos - 1000 Points / Month</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                You maintain at least 10 photos over 2+ properties.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="promoted" class="achievement">
                            <h1>Power Promoter - 1000 Points / Month</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                You have promoted any combinations of properties at least twice a month.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="rentgorilla" class="achievement">
                            <h1>Rent Gorilla - 10,000 Points</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                You have an active listing for a total of 365 days. This is easiest to achieve by simply modifying your date of availability.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="favourites" class="achievement">
                            <h1>Lots of Favorites - 5000 Points</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                Any combination of properties has received at least 20 favorites.
                            </p>
                            <span class="cf"></span>
                        </div>
                        <div id="star" class="achievement">
                            <h1>Movie Star - 10,000 Points</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                You have added links to at least two videos for any combination of properties and those videos have received at least 20 Likes.
                            </p>
                            <span class="cf"></span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="cf"></div>
    </section>
@endsection
@section('footer')
    <script>
    jQuery(document).ready(function($){
        $('.fa-question-circle').tooltip({
            position: { my: "bottom", at: "left center" }
        });
        $('.achievements_overview').tabs();
    });
</script>
@endsection