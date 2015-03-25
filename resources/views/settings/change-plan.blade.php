@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Your Subscrption Plan</h2>
<h3>Current Plan: TODO - get current plan</h3>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
            <form method="POST" action="https://laracasts.com/admin/subscription/plan" accept-charset="UTF-8"><input name="_method" type="hidden" value="PATCH"><input name="_token" type="hidden" value="w4yYVcTaSNFmvQBb1KFUjrroVuCVxoFgZUJbjoe0">    <div class="form-group">
                    <label for="subscription_type">Want to Change or Upgrade Your Subscription?</label>        <select class="form-control" name="stripe_plan"><option value="monthly">Monthly Subscription ($9)</option><option value="yearly" selected="selected">Yearly Subscription ($86)</option></select>    </div>

                <div class="form-group">
                    <label for="coupon-code">Have a Coupon?</label>        <input class="form-control" name="coupon-code" type="text" id="coupon-code">    </div>

                <div class="form-group">
                    <input class="btn btn-primary" data-confirm="Are you sure you want the subscription plan that has been selected?" type="submit" value="Update">    </div>
            </form>
        </div>
    </div>
</div>
@stop