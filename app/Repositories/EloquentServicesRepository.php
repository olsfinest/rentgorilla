<?php namespace RentGorilla\Repositories;

use RentGorilla\Service;

class EloquentServicesRepository implements ServicesRepository {

    public function getAll()
    {
        return Service::orderBy('name')->get();
    }

    public function fetchById($id)
    {
       return Service::where('id', $id)->firstOrFail();
    }


    public function update($id, $name)
    {

        $feature = $this->fetchById($id);

        $feature->name = $name;

        return $feature->save();

    }

    public function delete($id)
    {
        $feature = $this->fetchById($id);

        return $feature->delete();
    }

    public function create($name)
    {
        return Service::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Service::where('name', $name)->first();
    }
}