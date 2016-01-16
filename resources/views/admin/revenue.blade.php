@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Subscription Revenue</h1>
        <br>
        <table>
            <thead>
                <tr><th>Subscription Plan</th><th>Price</th><th>Subscribers</th><th>Revenue</th></tr>
            </thead>
            <tbody>
                @foreach($revenue['plans'] as $planId => $plan)
                   <tr><td>{{ $planId }}</td><td align="right">${{ number_format($plan['price'], 2) }}</td><td align="center">{{ $plan['count'] }}</td><td align="right">${{ number_format($plan['recurring'], 2) }}</td></tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <p><strong>Monthly Recurring Revenue: ${{ number_format($revenue['monthly_recurring'], 2) }}</strong></p>
        <p><strong>Yearly Recurring Revenue: ${{ number_format($revenue['yearly_recurring'], 2) }}</strong></p>
        <br>
        <h1><strong>Total Yearly Recurring Revenue: ${{ number_format($revenue['total_yearly_recurring'], 2) }}</strong></h1>
        <br>
    </section>
@stop