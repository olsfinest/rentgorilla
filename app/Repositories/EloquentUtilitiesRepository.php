<?php namespace RentGorilla\Repositories;

use RentGorilla\Utility;

class EloquentUtilitiesRepository implements UtilitiesRepository {

    public function getAll()
    {
        return Utility::orderBy('name')->get();
    }

    public function fetchById($id)
    {
        return Utility::where('id', $id)->firstOrFail();
    }

    public function update($id, $name)
    {

        $utility = $this->fetchById($id);

        $utility->name = $name;

        return $utility->save();

    }

    public function delete($id)
    {
        $utility = $this->fetchById($id);

        return $utility->delete();
    }

    public function create($name)
    {
        return Utility::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Utility::where('name', $name)->first();
    }

}