@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Update Your Credit Card</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
<p class="breather">Want to update the credit card that we have on file? Provide the new details here. Don't worry; your card information will never touch our servers.</p>

<form method="POST" action="https://laracasts.com/admin/subscriptions/update?2063" accept-charset="UTF-8" id="billing-form"><input name="_method" type="hidden" value="PATCH"><input name="_token" type="hidden" value="w4yYVcTaSNFmvQBb1KFUjrroVuCVxoFgZUJbjoe0">    <!-- Credit Card Number -->
<div class="form-group row">
    <label for="cc-number" class="col-md-3 control-label">Credit Card Number:</label>

    <div class="col-md-8">
        <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" placeholder="**** **** **** 1875" required>
    </div>
</div>

<!-- Expiration Date -->
<div class="form-group row">
    <label class="col-md-3 control-label">Expiration Date:</label>

    <div class="col-md-3">
        <select class="form-control cc-expiration-month" data-stripe="exp-month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>    </div>

    <div class="col-md-2 no-left-arm">
        <select class="form-control cc-expiration-year" data-stripe="exp-year"><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option></select>    </div>
</div>

<!-- CVV Number -->
<div class="form-group row">
    <label for="cvv" class="col-md-3 control-label" for="cc-cvv">CVV Number:</label>

    <div class="col-md-3">
        <input type="text" id="cvv" placeholder="" class="form-control input-md cvc" data-stripe="cvc" required>
    </div>
</div>

<div class="payment-errors col-md-8" style="display:none">
    </div>

<footer>
    <button type="submit" class="btn btn-primary">Update Credit Card</button>
</footer>
</form>
        </div>
    </div>
</div>
@stop