<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UtilitiesSeeder extends Seeder {

    protected $utilities = [
        'Electric',
        'Oil furnace',
        'Wood stove',
        'Propane',
        'Radiator'
    ];

    public function run()
    {

        $inserts = [];

        foreach($this->utilities as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('utilities')->insert($inserts);
    }

}