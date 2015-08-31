<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyHeatsRequest;
use RentGorilla\Repositories\HeatsRepository;

class HeatsController extends Controller
{

    /**
     * @var HeatsRepository
     */
    private $heatsRepository;

    function __construct(HeatsRepository $heatsRepository)
    {
        $this->middleware('admin');
        $this->heatsRepository = $heatsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $heats = $this->heatsRepository->getAll();

        return view('admin.heats.index', compact('heats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.heats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ModifyHeatsRequest $request
     * @return Response
     */
    public function store(ModifyHeatsRequest $request)
    {

        if ($this->heatsRepository->nameExists($request->name)) {
            return redirect()->route('admin.heats.index')->with('flash:success', 'That heating type already exists!');
        }

        $this->heatsRepository->create($request->name);

        return redirect()->route('admin.heats.index')->with('flash:success', 'A new heating type has been added!');
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
        $heat = $this->heatsRepository->fetchById($id);

        return view('admin.heats.edit', compact('heat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModifyHeatsRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ModifyHeatsRequest $request, $id)
    {

        if ($this->heatsRepository->nameExists($request->name)) {
            return redirect()->route('admin.heats.index')->with('flash:success', 'That type of heating already exists!');
        }

        $this->heatsRepository->update($id, $request->name);

        return redirect()->route('admin.heats.index')->with('flash:success', 'A heating type has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->heatsRepository->delete($id);

        return redirect()->route('admin.heats.index')->with('flash:success', 'The heating type has been deleted!');
    }

    public function delete($id)
    {
        $heat = $this->heatsRepository->fetchById($id);

        return view('admin.heats.delete', compact('heat'));
    }
}
