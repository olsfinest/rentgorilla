@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    <section class="content full admin">
        <h1>Free Promotions</h1>

        {!! Form::open(['method' => 'POST', 'route' => 'admin.free-promotions.location']) !!}

           <label>Location:
            {!! Form::select('location', $locations->lists('city', 'slug'), $locationSlug, ['autocomplete' => 'off']) !!}
           </label>

            {!! Form::submit('Go') !!}

        {!! Form::close() !!}

        @if( ! $locationSlug)
            <p>Please select a location.</p>
        @endif

        @if($location)
            <hr>
            <h1>Promote a Property in {{ $location->cityAndProvince() }}</h1>

            {!! Form::open(['route' => 'admin.free-promotions.store', 'method' => 'POST']) !!}

                <select name="rental_id" id="address" style=""></select>

                {!! Form::submit('Promote') !!}

            {!! Form::close() !!}

            @section('footer')
                <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
                <script language="JavaScript" type="text/javascript">

                    $('#address').select2({
                        minimumInputLength: 3,
                        placeholder: 'Address',
                        ajax: {
                            type: 'POST',
                            url: '/admin/free-promotions/address-search/{{ $locationSlug }}',
                            dataType: 'json',
                            data: function (term, page) {
                                return {
                                    address: term
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            }
                        }
                    });


                </script>
            @endsection

            <hr>

            <p><strong>Currently Promoted Properties:</strong></p>
            @if($promotedCount = $location->promotedRentals()->count())
                <table>
                    <thead><tr><th>Address</th><th>Free</th><th>Promotion Ends</th><th>Cancel</th></tr></thead>
                    <tbody>
                        @foreach($location->promotedRentals as $promoted)
                            <tr><td>{{ $promoted->street_address }}</td>
                                <td>{{ $promoted->isNotFreePromotion() ? 'no' : 'yes' }}</td>
                                <td>{{ $promoted->promotion_ends_at }}</td><td>
                                @if( ! $promoted->isNotFreePromotion())
                                    <a href="{{ route('admin.free-promotions.confirm', $promoted->uuid) }}" class="button">Cancel</a>
                                @else
                                    n/a
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <p> {{ $promotedCount }} currently promoted {{ str_plural('property', $promotedCount) }}.</p>

            <p><strong>Currently Queued Properties:</strong></p>
            @if($queuedCount = $location->queuedRentals()->count())
                <table>
                    <thead><tr><th>Address</th><th>Free</th><th>Queued At</th><th>Cancel</th></tr></thead>
                    <tbody>
                        @foreach($location->queuedRentals as $queued)
                            <tr><td>{{ $queued->street_address }}</td>
                                <td>{{ $queued->isNotFreePromotion() ? 'no' : 'yes' }}</td>
                                <td>{{ $queued->queued_at }}</td><td>
                                @if( ! $queued->isNotFreePromotion())
                                    <a href="{{ route('admin.free-promotions.confirm', $queued->uuid) }}" class="button">Cancel</a>
                                @else
                                    n/a
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <p> {{ $queuedCount }} queued {{ str_plural('property', $queuedCount) }}.</p>
        @endif
    </section>
@stop