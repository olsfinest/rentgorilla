@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Update Date of Availability for {{ $rental->getAddress() }}</h1>
        <p>Please note: Making your listing in-active does not cancel your subscription. Visit <a href="{{ route('changePlan') }}">Billing > Subscription</a> to make that adjustment.  </p>

        @include('errors.error-list')
        {!! Form::model($rental, ['route' => ['rental.availability.update', $rental->uuid], 'method' => 'PATCH']) !!}

        <input class="form-control" type="radio" name="date" value="deactivate" {{ old('date') === 'deactivated' ? 'checked' : '' }}> Deactivate listing<br>
        <input type="radio" name="date" value="today" {{ old('date') === 'today' ? 'checked' : '' }}> Make listing available today ({{ Carbon\Carbon::now()->format('F j, Y') }})<br>
        <input type="radio" name="date" value="month" {{ old('date') === 'month' ? 'checked' : '' }}> Make listing available 30 days from now ({{ Carbon\Carbon::now()->addDays(30)->format('F j, Y') }})<br>
        <input type="radio" name="date" value="year" {{ old('date') === 'year' ? 'checked' : '' }}> Make listing available 1 year from now ({{ Carbon\Carbon::now()->addYear()->format('F j, Y') }})<br>
        <input type="radio" name="date" value="custom" {{ old('date') === 'custom' ? 'checked' : '' }}> Select custom date of availability: {!! Form::text('available', null, ['id' => 'available', 'class' => 'form-control', 'readonly', 'placeholder' => 'MM/DD/YYYY']) !!}
        <br>
        <button type="submit" class="button">Submit</button>

        {!! Form::close() !!}
    </section>
@stop

@section('footer')
    <script>
        $('#available').datepicker();
    </script>
@endsection