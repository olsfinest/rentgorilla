<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifySafetyRequest;
use RentGorilla\Repositories\SafetiesRepository;

class SafetiesController extends Controller
{

    /**
     * @var SafetiesRepository
     */
    protected $safetiesRepository;

    function __construct(SafetiesRepository $safetiesRepository)
    {
        $this->middleware('admin');
        $this->safetiesRepository = $safetiesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $safeties = $this->safetiesRepository->getAll();

        return view('admin.safeties.index', compact('safeties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.safeties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModifySafetyRequest $request
     * @return Response
     */
    public function store(ModifySafetyRequest $request)
    {

        if($this->safetiesRepository->nameExists($request->name)) {
            return redirect()->route('admin.safeties.index')->with('flash:success', 'That safety already exists!');
        }

        $this->safetiesRepository->create($request->name);

        return redirect()->route('admin.safeties.index')->with('flash:success', 'A new safety has been added!');
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
        $safety = $this->safetiesRepository->fetchById($id);

        return view('admin.safeties.edit', compact('safety'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModifySafetyRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ModifySafetyRequest $request, $id)
    {

        if($this->safetiesRepository->nameExists($request->name)) {
            return redirect()->route('admin.safeties.index')->with('flash:success', 'That safety already exists!');
        }

        $this->safetiesRepository->update($id, $request->name);

        return redirect()->route('admin.safeties.index')->with('flash:success', 'A safety has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->safetiesRepository->delete($id);

        return redirect()->route('admin.safeties.index')->with('flash:success', 'The safety has been deleted!');
    }

    public function delete($id)
    {
        $safety = $this->safetiesRepository->fetchById($id);

        return view('admin.safeties.delete', compact('safety'));
    }
}
