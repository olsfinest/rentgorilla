<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppliancesSeeder extends Seeder  {

    protected $appliances = [
        'Fridge',
        'Stove',
        'Microwave',
        'Dishwasher',
        'Air conditioner',
        'Freezer',
        'Garbage disposal'
   ];

    public function run()
    {

        $inserts = [];

        foreach($this->appliances as $name)
        {
            $inserts[] = ['name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('appliances')->insert($inserts);
    }


}