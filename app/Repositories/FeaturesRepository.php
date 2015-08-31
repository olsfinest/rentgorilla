<?php namespace RentGorilla\Repositories;

interface FeaturesRepository {

    public function getAll();
    public function fetchById($id);
    public function update($id, $name);
    public function delete($id);
    public function create($name);
    public function nameExists($name);

}