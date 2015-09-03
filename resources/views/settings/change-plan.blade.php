
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
                    However, once your trial ends, and you are within a year of joining the site, your account will be limited to 1 listing.
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
                        @foreach(Config::get('rewards') as $reward => $rewardProps)
                            <li><a href="#{{ $reward }}">{{ $rewardProps['name'] }}</a></li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                    @foreach(Config::get('rewards') as $reward => $rewardProps)
                        <div id="{{ $reward }}" class="achievement">
                            <h1>{{ $rewardProps['name'] }} - {{ $rewardProps['points'] . ($rewardProps['monthly'] ? ' points/month' : ' points') }}</h1>
                            <img src="/img/achievements_badge_small.png" alt="">
                            <p>
                                {{ $rewardProps['description'] }}
                            </p>
                            <span class="cf"></span>
                        </div>
                    @endforeach
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