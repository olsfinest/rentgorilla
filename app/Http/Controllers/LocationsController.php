<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\CreateLocationRequest;
use RentGorilla\Http\Requests\EditLocationRequest;
use RentGorilla\Repositories\LocationRepository;

class LocationsController extends Controller
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;


    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = $this->locationRepository->getAllPaginated(20);

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocationRequest $request)
    {

        $locationId = $this->locationRepository->getLocation($request->city, $request->county, $request->province);

        $location = $this->locationRepository->fetchById($locationId);

        $location->zoom = $request->zoom;

        $location->save();

        return redirect()->route('admin.locations.index')->with('flash:success', 'Location created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = $this->locationRepository->fetchById($id);

        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|EditLocationRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditLocationRequest $request, $id)
    {
        $location = $this->locationRepository->fetchById($id);

        $location->zoom = $request->zoom;

        $location->save();

        return redirect()->route('admin.locations.index')->with('flash:success', 'Location edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
