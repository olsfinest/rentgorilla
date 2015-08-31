<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyFeaturesRequest;
use RentGorilla\Repositories\FeaturesRepository;

class FeaturesController extends Controller
{

    /**
     * @var FeaturesRepository
     */
    protected $featuresRepository;

    function __construct(FeaturesRepository $featuresRepository)
    {
        $this->middleware('admin');
        $this->featuresRepository = $featuresRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $features = $this->featuresRepository->getAll();

        return view('admin.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ModifyFeaturesRequest  $request
     * @return Response
     */
    public function store(ModifyFeaturesRequest $request)
    {

        if($this->featuresRepository->nameExists($request->name)) {
            return redirect()->route('admin.features.index')->with('flash:success', 'That feature already exists!');
        }

        $this->featuresRepository->create($request->name);

        return redirect()->route('admin.features.index')->with('flash:success', 'A new feature has been added!');
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
        $feature = $this->featuresRepository->fetchById($id);

        return view('admin.features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModifyFeaturesRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(ModifyFeaturesRequest $request, $id)
    {

        if($this->featuresRepository->nameExists($request->name)) {
            return redirect()->route('admin.features.index')->with('flash:success', 'That feature already exists!');
        }

        $this->featuresRepository->update($id, $request->name);

        return redirect()->route('admin.features.index')->with('flash:success', 'A feature has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->featuresRepository->delete($id);

        return redirect()->route('admin.features.index')->with('flash:success', 'The feature has been deleted!');
    }

    public function delete($id)
    {
        $feature = $this->featuresRepository->fetchById($id);

        return view('admin.features.delete', compact('feature'));
    }
}
