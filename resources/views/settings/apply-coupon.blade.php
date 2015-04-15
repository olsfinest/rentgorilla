@extends('layouts.main')
@section('header-text')
<h2 class="jumbotron__heading">Apply a Coupon</h2>
@stop
@section('content')
@include('partials.settings-header')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            @include('partials.settings-sidebar')
        </div>
        <div class="col-md-8">
            @include('errors.error-list')
             <p class="breather">If you have a coupon, enter it here, and we'll apply it to your next billing cycle.</p>
             {!! Form::open(['route' => 'subscription.applyCoupon']) !!}
                    <div class="form-group">
                       <input id="coupon-code" class="form-control"  name="coupon_code" type="text">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Apply Coupon">
                    </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@stop