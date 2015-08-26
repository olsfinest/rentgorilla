<?php namespace RentGorilla\Repositories;

use Illuminate\Support\Str;
use RentGorilla\Location;
use DB;

class EloquentLocationRepository implements LocationRepository {

    public function locationSearch($city)
    {
        return Location::select([ DB::raw('concat(city, ", ", province) as text'), DB::raw('slug as id')])
            ->where(DB::raw('concat(city, ", ", province)'), 'like', "%$city%")
            ->get();
    }


    public function fetchBySlug($slug)
    {
        return Location::where('slug', $slug)->firstOrFail();
    }

    public function cityIsDuplicate($city, $county, $province)
    {
        /*
     return DB::table('rentals')
         ->where(function ($query) use ($city, $province, $county) {
             $query->where('city', $city)
                 ->where('province', $province)
                 ->where('county', '!=', $county);
         })->orWhere(function ($query) use ($city, $province, $county) {
             $query->where('province', $province)
                 ->where('county', '=', $county)
                 ->where('city', '=', $city . ' ' . $county);
         })->count() > 0;
 */
        $differentCounty = DB::table('locations')
            ->where('city', $city)
            ->where('province', $province)
            ->whereNotNull('county')
            ->where('county', '!=', $county)
            ->count();

        if($differentCounty > 0) return true;

        $alreadyDuplicate = DB::table('locations')
            ->where('province', $province)
            ->whereNotNull('county')
            ->where('county', '=', $county)
            ->where('city', '=', $city . ', ' . $county)
            ->count();

        if($alreadyDuplicate > 0) return true;

        return false;

    }

    public function getLocation($city, $county, $province)
    {

        if($county && $this->cityIsDuplicate($city, $county, $province)) {

            $location = Location::where([
                'slug' => Str::slug($city . '-' . $province)
            ])->first();


            if($location) {
                return $location->id;
            } else {

               $location = new Location();
                $location->city = $city . ', ' . $county;
                $location->county = $county;
                $location->province = $province;
                $location->slug = Str::slug($location->city . '-' . $province);
                $location->save();

                return $location->id;
            }
        }

        $location = Location::where([
            'slug' => Str::slug($city . '-' . $province)
        ])->first();

        if($location) {
            return $location->id;
        } else {
            $location = new Location();
            $location->city = $city;
            $location->county = nullIfEmpty($county);
            $location->province = $province;
            $location->slug = Str::slug($location->city . '-' . $province);
            $location->save();

            return $location->id;

        }
    }
}