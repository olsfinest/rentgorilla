<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder {

    protected $services = [
        'Reception',
        'Doorman',
        'Security Personnel - Internal',
        'Security Personnel - External',
        'Cleaning',
        'General Maintenance',
        'Winter Maintenance',
        'Lawn Care',
        'Septic',
        'Sewer',
        'Water'
    ];

    public function run()
    {

        $inserts = [];

        foreach($this->services as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('services')->insert($inserts);
    }

}