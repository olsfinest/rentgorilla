<?php namespace RentGorilla\Repositories;

interface LocationRepository {

    public function locationSearch($city);
    public function fetchBySlug($slug);
    public function cityIsDuplicate($city, $county, $province);
    public function getLocation($city, $county, $province);

}