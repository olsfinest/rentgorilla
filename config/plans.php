<?php

return [

    'Free' => [
        'maximumListings' => 1,
        'totalYearlyCost' => 0,
        'planName' => 'Free',
        'interval' => null
    ],

    'Personal_Monthly' => [
        'maximumListings' => 5,
        'totalYearlyCost' => 12000,
        'planName' => 'Personal - Monthly',
        'interval' => 'month'
    ],

    'Personal_Yearly' => [
        'maximumListings' => 5,
        'totalYearlyCost' => 9600,
        'planName' => 'Personal - Yearly',
        'interval' => 'year'
    ],

    'Professional_Monthly' => [
        'maximumListings' => 10,
        'totalYearlyCost' => 24000,
        'planName' => 'Professional - Monthly',
        'interval' => 'month'
    ],

    'Professional_Yearly' => [
        'maximumListings' => 10,
        'totalYearlyCost' => 19200,
        'planName' => 'Professional - Yearly',
        'interval' => 'year'
    ],

    'Business_Monthly' => [
        'maximumListings' => 'unlimited',
        'totalYearlyCost' => 36000,
        'planName' => 'Business - Monthly',
        'interval' => 'month'
    ],

    'Business_Yearly' => [
        'maximumListings' => 'unlimited',
        'totalYearlyCost' => 28800,
        'planName' => 'Business - Yearly',
        'interval' => 'year'
    ]
];