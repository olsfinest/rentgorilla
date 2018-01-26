<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Location;

class SitemapController extends Controller
{
    /**
     * Display a listing of the sitemap index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::whereHas('rentals', function ($query) {
            $query->where('active', 1);
        })->orderBy('updated_at', 'desc')->get();

        return response()->view('sitemap.index', [
            'locations' => $locations,
        ])->header('Content-Type', 'text/xml');
    }

    /**
     * Display a listing of all the active rentals for a location
     *
     * @param $locationSlug
     * @return \Illuminate\Http\Response
     */
    public function show($locationSlug)
    {
        $location = Location::where('slug', $locationSlug)
            ->firstOrFail();

        $rentals = $location->rentals()
            ->where('active', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('sitemap.show', [
            'rentals' => $rentals
        ])->header('Content-Type', 'text/xml');
    }

    /**
     * Display a listing of all the static pages
     *
     * @return \Illuminate\Http\Response
     */
    public function pages()
    {
        return response()->view('sitemap.pages')
            ->header('Content-Type', 'text/xml');
    }
}
