<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;

class FeedsController extends Controller {

	public function sitemap()
    {
        $out = '';

        $rentals = DB::table('rentals')->groupBy('location')->get();

        dd($rentals);

    }
}
