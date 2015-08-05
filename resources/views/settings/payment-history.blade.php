@extends('layouts.admin')
@section('content')
    <section class="content full admin">
    <h1>Payment History</h1>


                @if(Auth::user()->readyForBilling())

                        <h1 class="heading-top setting-heading">Next Invoice</h1>
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
                    <h1 class="heading-top setting-heading">Past Invoices</h1>
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
                        <h1 class="heading-top setting-heading">Property Promotion Charges</h1>
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
                                <tr><td>{{ \Carbon\Carbon::createFromTimestamp($charge->created)->toDayDateTimeString() }}</td><td>{{ $charge->description }}</td><td>${{ number_format($charge->amount / 100, 2) }}</td><td>{{ $charge->paid ? 'Paid' : 'Unpaid'  }}</td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No property promotion charges.</p>
                    @endif



            @else
                <p>No payment history.</p>
            @endif


</section>
@stop