<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyAppliancesRequest;
use RentGorilla\Repositories\AppliancesRepository;

class AppliancesController extends Controller
{

    /**
     * @var AppliancesRepository
     */
    protected $appliancesRepository;

    function __construct(AppliancesRepository $appliancesRepository)
    {
        $this->middleware('admin');

        $this->appliancesRepository = $appliancesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $appliances = $this->appliancesRepository->getAll();

        return view('admin.appliances.index', compact('appliances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.appliances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ModifyAppliancesRequest $request
     * @return Response
     */
    public function store(ModifyAppliancesRequest $request)
    {

        if ($this->appliancesRepository->nameExists($request->name)) {
            return redirect()->route('admin.appliances.index')->with('flash:success', 'That appliance already exists!');
        }

        $this->appliancesRepository->create($request->name);

        return redirect()->route('admin.appliances.index')->with('flash:success', 'A new appliance has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $appliance = $this->appliancesRepository->fetchById($id);

        return view('admin.appliances.edit', compact('appliance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModifyAppliancesRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ModifyAppliancesRequest $request, $id)
    {

        if ($this->appliancesRepository->nameExists($request->name)) {
            return redirect()->route('admin.appliances.index')->with('flash:success', 'That appliance already exists!');
        }

        $this->appliancesRepository->update($id, $request->name);

        return redirect()->route('admin.appliances.index')->with('flash:success', 'An appliance has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->appliancesRepository->delete($id);

        return redirect()->route('admin.appliances.index')->with('flash:success', 'The appliance has been deleted!');
    }

    public function delete($id)
    {
        $appliance = $this->appliancesRepository->fetchById($id);

        return view('admin.appliances.delete', compact('appliance'));
    }
}
