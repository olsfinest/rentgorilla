<?php namespace RentGorilla\Repositories;

use RentGorilla\Rental;
use RentGorilla\User;

interface RentalRepository
{
    public function search($page, $paginate, $city, $province, $type, $availability, $beds, $price);
    public function uuids($city, $province, $type, $availability, $beds, $price);
    public function geographicSearch($north, $south, $west, $east, $type = null, $availability = null, $beds = null, $price = null);
    public function getRentalsByIds(array $ids);
    public function locationSearch($city);
    public function getRentalsForUser(User $user);
    public function find($id);
    public function findRentalForUser(User $user, $id);
    public function activate(Rental $rental);
    public function deactivate(Rental $rental);
    public function getActiveRentalCountForUser(User $user);
    public function deactivateAllForUser(User $user);
    public function downgradePlanCapacityForUser(User $user, $capacity);
    public function getPromotedRentals(User $user);
    public function getUnpromotedRentals(User $user);
    public function promoteRental(Rental $rental);
    public function unpromoteRental(Rental $rental);
    public function findByUUID($id);
    public function getPhoneByRental(Rental $rental);
    public function getUserByRental(Rental $rental);
    public function locationExists($location);
    public function queueRental(Rental $rental);
    public function unqueueRental(Rental $rental);
    public function delete(Rental $rental);
    public function incrementViews(Rental $rental);
    public function cityIsDuplicate($city, $county, $province);
    public function incrementEmailClick(Rental $rental);
    public function incrementPhoneClick(Rental $rental);
    public function updateSearchViews($rentalIds);
}