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
                        <h2 class="heading-top setting-heading">Upcoming Invoice</h2>

                        <table class="table table-bordered table-section">
                            <thead class="accent">
                                <tr>
                                    <th>Date</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Dec 22, 2014</td>
                                    <td>$51.60</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <div>
                    <h2 class="heading-top setting-heading">Payment History</h2>

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
                                                        <tr>
                                        <td>Dec 22, 2013</td>
                                        <td>$60.20</td>
                                        <td>Paid</td>
                                        <td><a href="https://laracasts.com/admin/subscription/invoices/in_3Ahb99tFQbXIsm">View</a></td>
                                    </tr>
                                                </tbody>
                        </table>
                        </div>

                <hr>

                <div>
                    <p>
                        Need to associate special billing information (address, instructions, etc.) with your invoices? Add it below,
                        and we'll make sure that it's included.
                    </p>

                    <!-- Update billing information for invoices -->
                    <form method="POST" action="https://laracasts.com/admin/subscription/invoices" accept-charset="UTF-8"><input name="_method" type="hidden" value="PATCH"><input name="_token" type="hidden" value="w4yYVcTaSNFmvQBb1KFUjrroVuCVxoFgZUJbjoe0">            <div class="form-group">
                            <textarea class="form-control" name="billing_details" cols="50" rows="10"></textarea>            </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update Billing Info">            </div>
                    </form>    </div>
        </div>
    </div>
</div>
@stop