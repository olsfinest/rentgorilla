<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SafetiesSeeder extends Seeder {

    protected $safeties = [
        'Carbon Monoxide Detector - Battery',
        'Carbon Monoxide Detector - Wired',
        'Carbon Monoxide Detector - Plugin',
        'Carbon Monoxide Detector - Wired/Battery',
        'Smoke Detectors - Battery',
        'Smoke Detectors - Wired',
        'Smoke Detectors - Plugin',
        'Smoke Detectors - Wired/Battery',
        'Emergency Exits',
        'Egress Windows (Fire Code)',
        'Fire Extinguisher(s)',
        'Sprinkler',
        'Security System',
        'Security Cameras'
    ];

    public function run()
    {

        $inserts = [];

        foreach($this->safeties as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('safeties')->insert($inserts);
    }

}