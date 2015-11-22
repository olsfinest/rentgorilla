<?php namespace RentGorilla\Repositories;

interface LocationRepository {

    public function locationSearch($city);
    public function fetchBySlug($slug);
    public function fetchById($id);
    public function cityIsDuplicate($city, $county, $province);
    public function getLocation($city, $county, $province);
    public function searchSlugForCity($city);
    public function getAllPaginated($perPage);
    public function getAll();

}