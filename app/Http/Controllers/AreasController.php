<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Commands\EditAreaCommand;
use RentGorilla\Commands\CreateAreaCommand;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Repositories\AreasRepository;
use RentGorilla\Http\Requests\ModifyAreaRequest;

class AreasController extends Controller
{

    /**
     * @var AreasRepository
     */
    private $repository;

    function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = $this->repository->getAllPaginated(20);

        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|ModifyAreaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModifyAreaRequest $request)
    {
        $this->dispatch(new CreateAreaCommand($request->name, $request->province));

        return redirect()->route('admin.areas.index')->with('flash:success', 'The ' . $request->name . ' Area has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $area = $this->repository->fetchById($id);

        return view('admin.areas.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = $this->repository->fetchById($id);

        return view('admin.areas.edit', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $area = $this->repository->fetchById($id);

        return view('admin.areas.confirm-delete', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|ModifyAreaRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModifyAreaRequest $request, $id)
    {
        $this->dispatch(new EditAreaCommand($id, $request->name, $request->province));

        return redirect()->route('admin.areas.index')->with('flash:success', 'The ' . $request->name . ' Area has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = $this->repository->fetchById($id);

        if( ! $area->canDelete()) {
            return redirect()->route('admin.areas.index')->with('flash:success', 'The ' . $area->name . ' Area could not be deleted as locations reference it');
        }

        $this->repository->delete($area);

        return redirect()->route('admin.areas.index')->with('flash:success', 'The ' . $area->name . ' Area has been successfully deleted');
    }
}
