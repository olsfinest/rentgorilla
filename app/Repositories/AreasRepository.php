<?php namespace RentGorilla\Repositories;

interface AreasRepository
{
    public function fetchAll();
    public function fetchForSelect();
    public function fetchById($id);
    public function fetchBySlug($slug);
    public function getAllPaginated($perPage);
    public function create($name, $province);
    public function edit($id, $name, $province);
    public function delete($area);
}