<?php namespace RentGorilla\Repositories;

use RentGorilla\User;

interface RentalRepository
{
    public function search($city, $province, $type, $availability, $beds, $price);
    public function geographicSearch($north, $south, $west, $east, $type = null, $availability = null, $beds = null, $price = null);
    public function getRentalsByIds(array $ids);
    public function locationSearch($city);
    public function getRentalsForUser(User $user);
    public function find($id);
    public function findRentalForUser(User $user, $id);
    public function activate($rental_id);
    public function deactivate($rental_id);
    public function getActiveRentalCountForUser(User $user);

}