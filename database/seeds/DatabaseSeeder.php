<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Laracasts\TestDummy\Factory;
use RentGorilla\Location;

class DatabaseSeeder extends Seeder {

	const TOTAL_USERS = 20;
	const TOTAL_RENTALS = 100;
	const MAX_PRICE = 1500;
	const MAX_BEDS = 6;

	private $faker;

	private $images = ['01.jpg', '02.jpg', '03.jpg', '04.jpg', '05.jpg', '06.jpg', '07.jpg', '08.jpg', '09.jpg', '10.jpg'];
	private $types = ['house', 'apartment', 'room'];
	private $cities = ['Antigonish', 'Halifax', 'New Minas'];
   function __construct()
	{
		$this->faker = \Faker\Factory::create('en_CA');
	}

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	    return;

        Model::unguard();

        $newMinas = Location::create([
            'province' => 'NS',
            'city' => 'New Minas',
            'slug' => 'new-minas-ns'
        ]);

        $antigonish = Location::create([
            'province' => 'NS',
            'city' => 'Antigonish',
            'slug' => 'antigonish-ns'
        ]);

        $halifax = Location::create([
            'province' => 'NS',
            'city' => 'Halifax',
            'slug' => 'halifax-ns'
        ]);

        $user = Factory::create('RentGorilla\User', ['email' => 'test@test.com', 'password' => bcrypt('password'), 'is_admin' => 1]);

		//create TOTAL_USERS users
		$users = Factory::times(self::TOTAL_USERS - 1)->create('RentGorilla\User');

        $users[] = $user;

        foreach (range(1, self::TOTAL_RENTALS) as $numRentals) {

			//get a random user
			$user = $users->random();

            $rentalModelOverrides = [
                    'user_id' => $user->id,
                    'uuid' => Hashids::encode($numRentals),
                    'type' => $this->getRandomType(),
                    'price' => $this->getRandomPrice(),
                    'beds' => $this->getRandomBeds(),
                    'street_address' => $this->faker->streetAddress,
                    'available_at' => $this->getRandomDate()];

            $merged = array_merge($rentalModelOverrides, $this->getRandomLocation());

			//create TOTAL_RENTALS rentals for random users
			$rental = Factory::create('RentGorilla\Rental', $merged);

			//each rental will have three random photos
			Factory::create('RentGorilla\Photo', ['user_id' => $user->id, 'rental_id' => $rental->id , 'name' => $this->getRandomImage()]);
			Factory::create('RentGorilla\Photo', ['user_id' => $user->id, 'rental_id' => $rental->id , 'name' => $this->getRandomImage()]);
			Factory::create('RentGorilla\Photo', ['user_id' => $user->id, 'rental_id' => $rental->id , 'name' => $this->getRandomImage()]);
		}

        $this->call('FeaturesSeeder');
        $this->call('AppliancesSeeder');
        $this->call('HeatsSeeder');
		$this->call('UtilitiesSeeder');

   }

	private function getRandomImage()
	{
		return $this->faker->randomElement($this->images);
	}

	private function getRandomType()
	{
		return $this->faker->randomElement($this->types);
	}

	private function getRandomPrice()
	{
		return mt_rand(0, self::MAX_PRICE);
	}

	private function getRandomBeds()
	{
		return mt_rand(1, self::MAX_BEDS);
	}

	private function getRandomCity()
	{
		return $this->faker->randomElement($this->cities);
	}

	private function getRandomDate()
	{
		return $this->faker->dateTimeBetween('-1 month', '+8 months')->format('Y-m-d 00:00:00');
	}

    private function getRandomLocation(){

        $locations = [
            'New Minas' =>
                ['N' => 45.0830664,
                    'S' => 45.0539391,
                    'W' => -64.47981519999999,
                    'E' => -64.4171978],

            'Antigonish' =>
                ['N' => 45.63653009999999,
                    'S' => 45.6072643,
                    'W' => -62.0237288,
                    'E' => -61.9715071],

            'Halifax' =>
                ['N' => 44.7035312,
                    'S' => 44.5949302,
                    'W' => -63.68627009999999,
                    'E' => -63.5576784]
        ];

        $city = $this->getRandomCity();

        $numLocations = count($this->cities);

        $location_id = rand(1, $numLocations);

        $lat = $this->faker->randomFloat(6, $locations[$city]['S'], $locations[$city]['N']);
        $lng = $this->faker->randomFloat(6, $locations[$city]['W'], $locations[$city]['E']);

        return compact('lat', 'lng', 'location_id');

    }
}