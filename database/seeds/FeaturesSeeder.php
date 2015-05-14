<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder {

    protected $features = [
        'Hardwood Floors',
        'Hot Tub',
        'Deck',
        'Fireplace',
        'Private Yard',
        'Storage Shed',
        'Front Lawn',
        'Back Lawn',
        'Door Man',
        'Roof Access',
        'Deck/Patio',
        'Private Yard',
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