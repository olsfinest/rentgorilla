<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyServiceRequest;
use RentGorilla\Repositories\ServicesRepository;

class ServicesController extends Controller
{

    /**
     * @var ServicesRepository
     */
    protected $servicesRepository;

    function __construct(ServicesRepository $servicesRepository)
    {
        $this->middleware('admin');
        $this->servicesRepository = $servicesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $services = $this->servicesRepository->getAll();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModifyServiceRequest $request
     * @return Response
     */
    public function store(ModifyServiceRequest $request)
    {

        if($this->servicesRepository->nameExists($request->name)) {
            return redirect()->route('admin.services.index')->with('flash:success', 'That service already exists!');
        }

        $this->servicesRepository->create($request->name);

        return redirect()->route('admin.services.index')->with('flash:success', 'A new service has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $service = $this->servicesRepository->fetchById($id);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModifyServiceRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ModifyServiceRequest $request, $id)
    {

        if($this->servicesRepository->nameExists($request->name)) {
            return redirect()->route('admin.services.index')->with('flash:success', 'That service already exists!');
        }

        $this->servicesRepository->update($id, $request->name);

        return redirect()->route('admin.services.index')->with('flash:success', 'A service has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->servicesRepository->delete($id);

        return redirect()->route('admin.services.index')->with('flash:success', 'The service has been deleted!');
    }

    public function delete($id)
    {
        $service = $this->servicesRepository->fetchById($id);

        return view('admin.services.delete', compact('service'));
    }
}
