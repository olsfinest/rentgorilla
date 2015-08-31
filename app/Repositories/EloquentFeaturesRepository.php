<?php namespace RentGorilla\Repositories;

use RentGorilla\Feature;

class EloquentFeaturesRepository implements FeaturesRepository {

    public function getAll()
    {
        return Feature::orderBy('name')->get();
    }

    public function fetchById($id)
    {
       return Feature::where('id', $id)->firstOrFail();
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
        return Feature::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Feature::where('name', $name)->first();
    }
}