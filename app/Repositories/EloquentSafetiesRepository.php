<?php namespace RentGorilla\Repositories;

use RentGorilla\Safety;

class EloquentSafetiesRepository implements SafetiesRepository {

    public function getAll()
    {
        return Safety::orderBy('name')->get();
    }

    public function fetchById($id)
    {
       return Safety::where('id', $id)->firstOrFail();
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
        return Safety::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Safety::where('name', $name)->first();
    }
}