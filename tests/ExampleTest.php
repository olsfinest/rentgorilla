<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;

class ExampleTest extends DbTestCase {

    public function testBasicExample()
    {
        $city = 'New Minas';
        $province = 'NS';

        $rental = Factory::create('RentGorilla\Rental', ['city' => 'New Minas',
            'county' => 'Kings County'
        ]);

        $county = 'Kings County';

        $this->assertFalse($this->checkDuplicates($city, $province, $county));

        $county = 'Shit County';

        $this->assertTrue($this->checkDuplicates($city, $province, $county));

        $rental = Factory::create('RentGorilla\Rental', ['city' => 'New Minas Shit County',
            'county' => 'Shit County'
        ]);

        $city = 'New Minas';

        $county = 'Kings County';

        $this->assertFalse($this->checkDuplicates($city, $province, $county));



    }


    public function checkDuplicates($city, $province, $county)
    {

       /*
        return DB::table('rentals')
            ->where(function ($query) use ($city, $province, $county) {
                $query->where('city', $city)
                    ->where('province', $province)
                    ->where('county', '!=', $county);
            })->orWhere(function ($query) use ($city, $province, $county) {
                $query->where('province', $province)
                    ->where('county', '=', $county)
                    ->where('city', '=', $city . ' ' . $county);
            })->count() > 0;
    */
        $differentCounty = DB::table('rentals')
                    ->where('city', $city)
                    ->where('province', $province)
                    ->where('county', '!=', $county)
                    ->count();

        if($differentCounty > 0) return true;

            $alreadyDuplicate = DB::table('rentals')
                    ->where('province', $province)
                    ->where('county', '=', $county)
                    ->where('city', '=', $city . ' ' . $county)
                    ->count();

        if($alreadyDuplicate > 0) return true;

        return false;

    }

}
