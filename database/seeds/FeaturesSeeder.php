<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder {

    protected $features = [
        'Deck/patio',
        'Private yard',
        'Attached garage',
        'Furnished',
        'Open Concept',
        'Newly renovated'
    ];

    public function run()
    {

        $inserts = [];

        foreach($this->features as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('features')->insert($inserts);
    }

}