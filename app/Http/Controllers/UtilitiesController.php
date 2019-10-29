<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyutilitiesRequest;
use RentGorilla\Repositories\UtilitiesRepository;

class utilitiesController extends Controller
{

    /**
     * @var utilitiesRepository
     */
    private $utilitiesRepository;

    function __construct(utilitiesRepository $utilitiesRepository)
    {
        $this->middleware('admin');
        $this->utilitiesRepository = $utilitiesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $utilities = $this->utilitiesRepository->getAll();

        return view('admin.utilities.index', compact('utilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.utilities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ModifyutilitiesRequest $request
     * @return Response
     */
    public function store(ModifyutilitiesRequest $request)
    {

        if ($this->utilitiesRepository->nameExists($request->name)) {
            return redirect()->route('admin.utilities.index')->with('flash:success', 'That utilitying type already exists!');
        }

        $this->utilitiesRepository->create($request->name);

        return redirect()->route('admin.utilities.index')->with('flash:success', 'A new utilitying type has been added!');
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
        $utility = $this->utilitiesRepository->fetchById($id);

        return view('admin.utilities.edit', compact('utility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModifyutilitiesRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ModifyutilitiesRequest $request, $id)
    {

        if ($this->utilitiesRepository->nameExists($request->name)) {
            return redirect()->route('admin.utilities.index')->with('flash:success', 'That type of utilitying already exists!');
        }

        $this->utilitiesRepository->update($id, $request->name);

        return redirect()->route('admin.utilities.index')->with('flash:success', 'A utilitying type has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->utilitiesRepository->delete($id);

        return redirect()->route('admin.utilities.index')->with('flash:success', 'The utilitying type has been deleted!');
    }

    public function delete($id)
    {
        $utility = $this->utilitiesRepository->fetchById($id);

        return view('admin.utilities.delete', compact('utility'));
    }
}
