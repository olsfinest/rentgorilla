<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HeatsSeeder extends Seeder {

    protected $heats = [
        'Electric',
        'Oil furnace',
        'Wood stove',
        'Propane',
        'Radiator'
    ];

    public function run()
    {

        $inserts = [];

        foreach($this->heats as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('heats')->insert($inserts);
    }

}