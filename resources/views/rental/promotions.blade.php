@extends('layouts.main')

@section('header')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLISHABLE_KEY') }}">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('header-text')
    <h2 class="jumbotron__heading">Promote Properties</h2>
@stop
@section('content')
    @include('partials.settings-header')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @include('partials.settings-sidebar')
            </div>
            <div class="col-md-8">

                <h3>About Property Promotions</h3>

                <p>Property promotions cost ${{ $price }} for seven days. A promoted property will be at the top of the search results for that city.</p>
                <p>Also, only three promotions are allowed for any city at any given time, ensuring your property will be seen.</p>
                <p>If there are already three promotions running for your city, you may still purchase a promotion now and your property will be promoted at the earliest possible time.</p>
                <hr>


                @if(count($promoted))
                    <h3>Currently Promoted Properties</h3>
                    <ul>
                    @foreach($promoted as $property)
                        <li>{{ $property->street_address }} - Promotion Ends: {{ $property->promotion_ends_at->format('F jS, Y') }} ({{ $property->promotion_ends_at->diffForHumans() }}) </li>
                    @endforeach
                    </ul>
                    <hr>
                @endif



                <h3>Promote Property</h3>
                <br>

                <div class="payment-errors alert alert-danger" style="display: none"></div>

                @include('errors.error-list')

                @if(count($unpromoted))


                    @if(Auth::user()->readyForBilling())


                        {!! Form::open(['route' => 'rental.promote.existing', 'class' => 'form']) !!}


                        <div class="form-group row">
                            <label class="col-md-3 control-label" for="stripe_plan">Property:</label>
                            <div class="col-md-8">
                                {!! Form::select('rental_id', $unpromoted->lists('street_address', 'uuid'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>


                        <div class="form-group">
                            {!! Form::submit('Charge my Credit Card $' . $price, ['class' => 'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}

                    @else

                        {!! Form::open(['route' => 'rental.promote.new', 'class' => 'form', 'id' => 'cc-form']) !!}

                        <div class="form-group row">
                            <label class="col-md-3 control-label" for="stripe_plan">Property:</label>
                            <div class="col-md-8">
                                {!! Form::select('rental_id', $unpromoted->lists('street_address', 'uuid'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>


                        @include('partials.credit-card', [ 'submitButtonText' => 'Charge my Credit Card $' . $price])


                        {!! Form::close() !!}
                    @endif
                @else
                    <p>No active properties to promote.</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script src="/js/billing.js"></script>
@stop


