<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ModifyLandingPageRequest;
use RentGorilla\Http\Requests\ModifySlideRequest;
use RentGorilla\LandingPage;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Slide;
use Validator;
use Input;
use Image;

class LandingPageController extends Controller
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
        //
    }


    public function create($locationId)
    {
        $location = $this->locationRepository->fetchById($locationId);

        return view('admin.landing-pages.create', compact('location'));
    }

    public function store(ModifyLandingPageRequest $request, $locationId)
    {
        $location = $this->locationRepository->fetchById($locationId);

        $lp = LandingPage::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $location->landingPage()->associate($lp);

        $location->save();

        return redirect()->route('admin.locations.index')->with('flash:success', 'Landing Page created!');

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


    public function edit($locationId, $landingPageId)
    {
        $location = $this->locationRepository->fetchById($locationId);

        return view('admin.landing-pages.edit', compact('location'));
    }


    public function update(ModifyLandingPageRequest $request, $locationId)
    {
       $location = $this->locationRepository->fetchById($locationId);

        $lp = $location->landingPage;

        $lp->name = $request->name;
        $lp->description = $request->description;

        $lp->save();

        return redirect()->route('admin.locations.index')->with('flash:success', 'Landing Page updated!');

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

    public function slides($locationId)
    {
        $location = $this->locationRepository->fetchById($locationId);

        return view('admin.landing-pages.slides', compact('location'));
    }


    public function addSlide($locationId, Request $request)
    {
        $location = $this->locationRepository->fetchById($locationId);

        $landingPage = $location->landingPage;

        if($landingPage->slides->count() === Slide::MAX_COUNT)
        {
            $error = 'Slide count of ' . Slide::MAX_COUNT . ' exceeded.';

            if ($request->ajax()) {
                return response()->json(['error' => $error], 400);
            } else {
                return redirect()->back()->withErrors(new MessageBag(['error' => $error]));
            }
        }



        $v = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,gif|max:10000',
        ]);

        if ($v->fails())
        {
            if ($request->ajax()) {
                return response()->json(['error' => $v->errors()->first()], 400);
            } else {
                return redirect()->back()->withErrors($v->errors());
            }
        }

        $file = Input::file('file');

        $image = Image::make($file->getRealPath());

        $destinationPath = public_path() . Slide::IMAGE_PATH;
        $randomString = str_random(12);
        $extension = $file->guessClientExtension();
        $filename = $randomString . ".{$extension}";

        $upload_success = $image->fit(Slide::WIDTH, Slide::HEIGHT)
            ->save($destinationPath . $filename);

        if( $upload_success ) {

            $slide = new Slide();
            $slide->name = $filename;
            $slide->landing_page_id = $landingPage->id;
            $slide->save();

            if ($request->ajax()) {
                return response()->json('success', 200);
            } else {
                return redirect()->back();
            }

        } else {
            if ($request->ajax()) {
                return response()->json(['error' => 'There was a problem uploading the slide.'], 400);
            } else {
                return redirect()->back()->withErrors(['file' => 'There was a problem uploading the slide.']);
            }

        }
    }

    public function removeSlide($locationId, $landingPageId, $name)
    {
        $slide = Slide::where('name', $name)->firstOrFail();

        $slide->deleteSlide();

        $slide->delete();

        return redirect()->route('admin.locations.landing-page.slides', [$locationId, $landingPageId])->with('flash:success', 'Slide deleted!');
    }

    public function savePhotoOrder()
    {
        $photoIds = Input::get('photoIds');

        if(empty($photoIds))
        {
            return response()->json(['message' => 'No input given'], 422);

        } else {

            $i = count($photoIds);
            foreach($photoIds as $id)
            {
                Slide::where('name', $id)->update(['order' => $i]);
                $i--;
            }

            return response()->json(['message' => 'Success'], 200);
        }
    }

    public function editSlide($slideId)
    {
        $slide = Slide::where('id', $slideId)->firstOrFail();

        return view('admin.landing-pages.edit-slide', compact('slide'));
    }

    public function confirmDeleteSlide($slideId)
    {
        $slide = Slide::where('id', $slideId)->firstOrFail();

        return view('admin.landing-pages.delete-slide', compact('slide'));
    }

    public function updateSlide(ModifySlideRequest $request, $slideId)
    {
        $slide = Slide::where('id', $slideId)->firstOrFail();

        $slide->alt = $request->alt;

        $slide->save();

        return redirect()->route('admin.locations.landing-page.slides', [$slide->landingPage->location->id, $slide->landingPage->id])->with('flash:success', 'Slide updated!');
    }
}