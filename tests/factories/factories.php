<?php

$factory('RentGorilla\User', [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->email,
    'password' => bcrypt('password'),
    'confirmation' => str_random(40),
    'confirmed' => 1,
    'user_type' => 'landlord'
]);

$factory('RentGorilla\Rental', [
    'user_id' => 'factory:RentGorilla\User',
    'active' => 1,
    'type' => 'house',
    'price' => 0,
    'beds' => 1,
    'street_address' => '48 Perrier Drive',
    'city' => 'New Minas',
    'province' => 'NS',
    'available_at' => $faker->dateTime,
    'lat' => 45,
    'lng' => -64
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