@extends('layouts.app')
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/integrate.css">
@stop
@section('content')
    @include('partials.header')
<section class="main gorilla">
    <section class="content full">
        <h1>move on up&hellip;</h1>
        <form>
            <label>
                <span class="fa fa-search"></span>
                <select name="location" id="location" style="width: 100%">
                </select>
                <span class="fa fa-map"></span>
            </label>
        </form>
    </section>
</section>
<section class="main promofree">
    <section class="content full">
        <h1>Ad Free</h1>
        <p>At RentGorilla we believe that your space is sacred. If there is a way for us to reduce the clutter, it's gone. That means we only show you what you care about, nothing else, ever.</p>
        <div class="cf"></div>
    </section>
</section>
<section class="main zerorisk">
    <section class="content full">
        <h1>Zero Risk</h1>
        <p>
            Don't take our word for it. Try our rental technology out for yourself, for free. Property managers list their first property for free, for one year.
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
    <script language="JavaScript" type="text/javascript">
        $('#location').select2({
            placeholder: 'Please enter a city',
            minimumInputLength: 3,
            ajax: {
                url: '/location-list',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        location: term
                    };
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }
        });

        $('#location').on("change", function(e) {
            window.location.href = '/list/' + $(this).val();
        });

    </script>
@endsection