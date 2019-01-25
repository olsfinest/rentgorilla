<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\CreateLocationRequest;
use RentGorilla\Http\Requests\EditLocationRequest;
use RentGorilla\Repositories\AreasRepository;
use RentGorilla\Repositories\LocationRepository;

class LocationsController extends Controller
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;
    /**
     * @var AreasRepository
     */
    private $areasRepository;


    public function __construct(LocationRepository $locationRepository, AreasRepository $areasRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->areasRepository = $areasRepository;
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
        $areas = $this->areasRepository->fetchForSelect();

        return view('admin.locations.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|CreateLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocationRequest $request)
    {

        $locationId = $this->locationRepository->getLocation($request->city, $request->county, $request->province);

        $location = $this->locationRepository->fetchById($locationId);

        $location->zoom = $request->zoom;

        $location->area_id = $request->area_id === "" ? null : $request->area_id;

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

        $areas = $this->areasRepository->fetchForSelect();

        return view('admin.locations.edit', compact('location', 'areas'));
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

        $location->area_id = $request->area_id === "" ? null : $request->area_id;

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
