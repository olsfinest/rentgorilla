@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Apply a Coupon</h1>
        @include('errors.error-list')
        <p>If you have a coupon, enter it here, and we'll apply it to your next billing cycle.</p>
        {!! Form::open(['route' => 'subscription.applyCoupon']) !!}
        <input id="coupon-code" class=""  name="coupon_code" type="text">
        <input class="" type="submit" value="Apply Coupon">
        {!! Form::close() !!}
    </section>
@stop