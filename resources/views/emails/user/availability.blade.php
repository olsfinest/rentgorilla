@extends('emails.layouts.default')

@section('body')
    <p>
        You are receiving this email because {{ $address }} has a listed date of availability that is now 30+ days past the current date. In order to provide our users with the most accurate decision making information, we request you modify the date of availability of your listing by clicking the link below to automatically login into RentGorilla.ca and choose one of the presented options.
    </p>
    <p>
        PRO TIP: The default sorting of our listings results is based on which properties are recently updated. Adjusting your date of availability will provide the added benefit of placing your property at the top of our search results (excluding Promoted Properties). As more users adjust their properties it will start to "fall" down the results, but this does offer free increased visibility.
    </p>

    @include('emails.user.partials.button', ['route' => route('signed.availability', ['rental' => $rental_id, 'signature' => $signature]), 'title' => 'Modify Availability Date'])
@stop