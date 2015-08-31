<?php namespace RentGorilla\Repositories;

use RentGorilla\Heat;

class EloquentHeatsRepository implements HeatsRepository {

    public function getAll()
    {
        return Heat::orderBy('name')->get();
    }

    public function fetchById($id)
    {
        return Heat::where('id', $id)->firstOrFail();
    }

    public function update($id, $name)
    {

        $heat = $this->fetchById($id);

        $heat->name = $name;

        return $heat->save();

    }

    public function delete($id)
    {
        $heat = $this->fetchById($id);

        return $heat->delete();
    }

    public function create($name)
    {
        return Heat::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Heat::where('name', $name)->first();
    }

}