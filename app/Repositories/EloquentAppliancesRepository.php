<?php namespace RentGorilla\Repositories;

use RentGorilla\Appliance;

class EloquentAppliancesRepository implements AppliancesRepository {

    public function getAll()
    {
        return Appliance::orderBy('name')->get();
    }

    public function fetchById($id)
    {
        return Appliance::where('id', $id)->firstOrFail();
    }


    public function update($id, $name)
    {

        $appliance = $this->fetchById($id);

        $appliance->name = $name;

        return $appliance->save();

    }

    public function delete($id)
    {
        $appliance = $this->fetchById($id);

        return $appliance->delete();
    }

    public function create($name)
    {
        return Appliance::firstOrCreate(['name' => $name]);
    }

    public function nameExists($name)
    {
        return Appliance::where('name', $name)->first();
    }

}