@extends('layouts.app')
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/integrate.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    @include('partials.header')
<section class="main gorilla">
    <section class="content full">
        <h1>find your way home&hellip;</h1>
        <label>
            <select name="location" id="location" style="width: 100%; visibility: hidden;">
                @foreach($locations as $location)
                    <option {!! $location['rentalsCount'] > 0 ? 'data-area="false"' : 'data-area="true"' !!} value="{{ $location['slug'] }}">{{ $location['city'] }}, {{ $location['province'] }} ({{ $location['rentalsCount'] > 0 ? $location['rentalsCount'] .  ' Listings' : 'Area' }})</option>
                @endforeach
            </select>
            <br>
            <select name="area" id="area" style="width: 100%; visibility: hidden;">
            </select>
        </label>
        <div style="text-align: center; margin-top: 10px;">
            <button id="listing-search" class="button">Listing Search</button>
            <button id="map-search" class="button">Map Search</button>
        </div>
    </section>
</section>
<section class="main promofree">
    <section class="content full">
        <h1>Ad Free<small>Browsing</small></h1>
        <p>
            At RentGorilla we believe that your space is sacred. If there is a way for us to reduce the clutter, it's gone. That means we only show you what you care about, nothing else, ever.
        </p>
        <div class="cf"></div>
    </section>
</section>
<section class="main zerorisk">
    <section class="content full">
        <h1>Zero Risk</h1>
        <p>
            Don't take our word for it. Try our rental technology out for yourself, for free. Property managers list their first property for free, for {{ config('plans.freeForXDays') }} days.
        </p>
        <div class="cf"></div>
    </section>
</section> 
<section class="main simple">
    <section class="content full">
        <h1>Simple</h1>
        <p>
            Every single click has been counted, each element has been rigorously considered to offer you a powerful yet elegant way to find or rent your next property.
        </p>
        <div class="cf"></div>
    </section>
</section>
@endsection

@section('footer')
   <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script> -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script language="JavaScript" type="text/javascript">
        var $location = $('#location').select2({
            minimumResultsForSearch: Infinity
        });

        var $area = $('#area').select2({
            minimumResultsForSearch: Infinity
        });

        $area.next(".select2-container").hide();

        $location.on("select2:select", function (e) {
            if($location.find(":selected").data("area")) {
                $area.empty().trigger('change'); //clear all
                $.ajax({
                    type: 'GET',
                    url: '/areas/locations/' + $location.val()
                }).then(function (data) {
                    $area.empty().trigger('change'); //clear all
                    $.each(data, function(index, item) {
                        // create the option and append to Select2
                        var option = new Option(item.city + ', ' + item.province + ' (' + item.rentalsCount + ')', item.slug, true, true);
                        $area.append(option).trigger('change');
                    });

                    // manually trigger the `select2:select` event
                    $area.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                });

                $area.next(".select2-container").show();
            } else {
                $area.next(".select2-container").hide();
            }
        });

        $('#listing-search').on("click", function(e) {
            if($location.find(":selected").data("area")) {
                window.location.href = '/list/' + $('#area').val();
            } else {
                window.location.href = '/list/' + $('#location').val();
            }
        });

        $('#map-search').on("click", function(e) {
            if($location.find(":selected").data("area")) {
                window.location.href = '/map/' + $('#area').val();
            } else {
                window.location.href = '/map/' + $('#location').val();
            }
        });

        $location.trigger('select2:select');
    </script>
@endsection