<section class="content full pricing">
    <img alt="Achievements Badge" src="/img/achievements_large.png" alt="" class="align-left">
    <div class="achievements_container">
        <h2><a name="points"></a>Earn Credit With RentGorilla Achievements</h2>
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