<?php

$factory('RentGorilla\User', [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->email,
    'password' => bcrypt('password'),
    'confirmation' => str_random(40),
    'confirmed' => 1
]);

$factory('RentGorilla\Rental', [
    'uuid' => str_random(8),
    'user_id' => 'factory:RentGorilla\User',
    'promoted' => 0,
    'active' => 1,
    'type' => 'house',
    'price' => 0,
    'beds' => 1,
    'street_address' => '48 Perrier Drive',
    'city' => 'New Minas',
    'province' => 'NS',
    'location' => 'new-minas-ns',
    'county' => 'Kings County',
    'available_at' => $faker->dateTime,
    'lat' => 45,
    'lng' => -64,
    'square_footage' => 1000,
    'laundry' => 'unit_free',
    'description' => $faker->paragraph(),
    'disability_access' => 1,
    'smoking' => 0,
    'utilities_included' => 1,
    'heat_included' => 1,
    'furnished' => 1,
    'pets' => 'cats_dogs',
    'parking' => 'driveway',
    'deposit' => 500,
    'baths' => 3,
    'lease' => 12,
    'edited_at' => \Carbon\Carbon::now()
]);

$factory('RentGorilla\Photo', [
    'user_id' => 'factory:RentGorilla\User',
    'rental_id' => 'factory:RentGorilla\Rental',
    'name' => '/img/sample_listing_img.jpg'
]);

$factory('RentGorilla\Favourite', [
    'user_id' => 'factory:RentGorilla\User',
    'rental_id' => 'factory:RentGorilla\Rental',
]);

$factory('RentGorilla\Promotion', [
    'user_id' => 'factory:RentGorilla\User',
]);

$factory('RentGorilla\Like', [
    'user_id' => 'factory:RentGorilla\User',
    'rental_id' => 'factory:RentGorilla\Rental',
    'photo_id' => 'factory:RentGorilla\Photo'
]);

