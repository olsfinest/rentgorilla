@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Payment History</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
            <div>

                @if(Auth::user()->readyForBilling())

                        <h2 class="heading-top setting-heading">Next Invoice</h2>
                @if($upcomingInvoice)
                <table class="table table-bordered table-section">
                            <thead class="accent">
                                <tr>
                                    <th>Date</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>{{ $upcomingInvoice->dateString() }}</td>
                                    <td>{{ $upcomingInvoice->dollars() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No upcoming invoices.</p>

                @endif

                <div>
                    <h2 class="heading-top setting-heading">Past Invoices</h2>
                    @if(count($invoices))
                        <table class="table table-bordered table-section">
                            <thead class="accent">
                                <tr>
                                    <th>Date</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($invoices as $invoice)
                                <tr><td>{{ $invoice->dateString() }}</td><td>{{ $invoice->dollars() }}</td><td>{{ $invoice->paid ? 'Paid' : 'Unpaid'  }}</td><td><a href="/admin/subscription/invoices/{{$invoice->id}}">View</a></td></tr>
                            @endforeach
                                                </tbody>
                        </table>
                        @else
                            <p>No past invoices.</p>
                        @endif
                        </div>

                    @if(count($charges))
                        <h2 class="heading-top setting-heading">Property Promotion Charges</h2>
                        <table class="table table-bordered table-section">
                            <thead class="accent">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($charges as $charge)
                                @if($charge->description)
                                    <tr><td>{{ \Carbon\Carbon::createFromTimestamp($charge->created)->format('F jS, Y') }}</td><td>{{ $charge->description }}</td><td>${{ ($charge->amount / 100) }}</td><td>{{ $charge->paid ? 'Paid' : 'Unpaid'  }}</td></tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No property promotion charges.</p>
                    @endif



            @else
                <p>No payment history.</p>
            @endif



        </div>
    </div>
</div>
@stop