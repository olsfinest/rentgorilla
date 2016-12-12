<?php

$unitPrice = 1000;
$totalNewPlans = 50;
$newPlans = [];

foreach(range(1, $totalNewPlans) as $plan) {
    $planID = $plan . '_active_monthly';
    $planName = sprintf('%s Active %s - Monthly', $plan, $plan === 1 ? 'Property' : 'Properties');
    $newPlans[$planID] = [
        'maximumListings' => $plan,
        'totalYearlyCost' => $unitPrice * $plan * 12,
        'planName' => $planName,
        'interval' => 'month',
        'isLegacy' => false
    ];
}

return [

    'freeForXDays' => 90,

    'unitPrice' => $unitPrice,

    'plans' => $newPlans + [

        'Free' => [
            'maximumListings' => 1,
            'totalYearlyCost' => 0,
            'planName' => 'Free',
            'interval' => null,
            'isLegacy' => true
        ],

        'Personal_Monthly' => [
            'maximumListings' => 5,
            'totalYearlyCost' => 12000,
            'planName' => 'Personal - Monthly',
            'interval' => 'month',
            'isLegacy' => true
        ],

        'Personal_Yearly' => [
            'maximumListings' => 5,
            'totalYearlyCost' => 9600,
            'planName' => 'Personal - Yearly',
            'interval' => 'year',
            'isLegacy' => true
        ],

        'Professional_Monthly' => [
            'maximumListings' => 10,
            'totalYearlyCost' => 24000,
            'planName' => 'Professional - Monthly',
            'interval' => 'month',
            'isLegacy' => true
        ],

        'Professional_Yearly' => [
            'maximumListings' => 10,
            'totalYearlyCost' => 19200,
            'planName' => 'Professional - Yearly',
            'interval' => 'year',
            'isLegacy' => true
        ],

        'Business_Monthly' => [
            'maximumListings' => 'unlimited',
            'totalYearlyCost' => 36000,
            'planName' => 'Business - Monthly',
            'interval' => 'month',
            'isLegacy' => true
        ],

        'Business_Yearly' => [
            'maximumListings' => 'unlimited',
            'totalYearlyCost' => 28800,
            'planName' => 'Business - Yearly',
            'interval' => 'year',
            'isLegacy' => true
        ]
    ]
];