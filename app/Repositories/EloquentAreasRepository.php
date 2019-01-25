<?php namespace RentGorilla\Repositories;

use RentGorilla\Area;

class EloquentAreasRepository implements AreasRepository
{

    public function getAllPaginated($perPage)
    {
        return Area::paginate($perPage);
    }

    public function create($name, $province)
    {
        return Area::create([
           'name' => $name,
           'province' => $province,
            'slug' => str_slug($name . '-' . $province)
        ]);
    }

    public function fetchById($id)
    {
        return Area::findOrFail($id);
    }

    public function edit($id, $name, $province)
    {
        $area = $this->fetchById($id);
        $area->name = $name;
        $area->province = $province;
        $area->slug = str_slug($name . '-' . $province);
        $area->save();

        return $area;
    }

    public function delete($area)
    {
        return $area->delete();
    }

    public function fetchAll()
    {
        return Area::all();
    }

    public function fetchForSelect()
    {
        $blank = ['' => '(None)'];

        return $blank + Area::lists('name', 'id')->toArray();
    }

    public function fetchBySlug($slug)
    {
        return Area::where('slug', $slug)->firstOrFail();
    }
}