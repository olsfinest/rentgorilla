<?php namespace RentGorilla\Repositories;

use Config;
use DB;
use Carbon\Carbon;
use RentGorilla\Rental;
use RentGorilla\User;

class EloquentRentalRepository implements RentalRepository
{

    protected function baseSearch($photos, $city = null, $province = null, $type = null, $availability = null, $beds = null, $price = null)
    {

       if($photos) {
           $query = Rental::with('photos');
       } else {
           $query = DB::table('rentals');
       }
        $query->where('active', 1);

        if ($city) {
            $query->where('city', '=', $city);
        }

        if ($province) {
            $query->where('province', '=', $province);
        }

        if ($type) {
            $query->where('type', '=', $type);
        }

        if ($availability) {
            switch($availability) {
                case '0-2':
                    $query->where('available_at', '<=', Carbon::today()->addMonths(2));
                    break;
                case '2-4':
                    $query->whereBetween('available_at', [Carbon::today()->addMonths(2), Carbon::today()->addMonths(4)]);
                    break;
                case '4-6':
                    $query->whereBetween('available_at', [Carbon::today()->addMonths(4), Carbon::today()->addMonths(6)]);
                    break;
                case '6plus':
                    $query->where('available_at', '>', Carbon::today()->addMonths(6));
                    break;
            }
        } else {
            $query->where('available_at', '<=', Carbon::today());
        }

        if ($beds) {
            if($beds == '5plus') {
                $query->where('beds', '>=', 5);
            } else {
                $query->where('beds', '=', $beds);
            }
        }

        if ($price) {
            switch ($price) {
                case 'tier1':
                    $query->whereBetween('price', [0, 299]);
                    break;
                case 'tier2':
                    $query->whereBetween('price', [300, 699]);
                    break;
                case 'tier3':
                    $query->whereBetween('price', [700, 999]);
                    break;
                case 'tier4':
                    $query->whereBetween('price', [1000, 1399]);
                    break;
                case 'tier5':
                    $query->where('price', '>=', '1400');
                    break;
            }
        }

        return $query;

    }

    public function search($page = 1, $paginate = false, $city = null, $province = null, $type = null, $availability = null, $beds = null, $price = null)
    {
        $count = $this->baseSearch(false, $city, $province, $type, $availability, $beds, $price)->count();

        $totalPages = ceil($count / Rental::RESULTS_PER_PAGE);

        $query = $this->baseSearch(true, $city, $province, $type, $availability, $beds, $price)->orderBy('available_at');

        if($paginate) {
            $offset = ($page - 1) * Rental::RESULTS_PER_PAGE;
            $results = $query->skip($offset)->take(Rental::RESULTS_PER_PAGE)->get();
        } else {
            if($page <= $totalPages) {
                $limit = $page * Rental::RESULTS_PER_PAGE;
                $results = $query->skip(0)->take($limit)->get();
            } else {
                $page = $totalPages;
                $results = $query->get();
            }
        }

        return compact('count', 'results', 'page', 'totalPages');
    }

    public function uuids($city = null, $province = null, $type = null, $availability = null, $beds = null, $price = null)
    {
        $query = $this->baseSearch(true, $city, $province, $type, $availability, $beds, $price);

        $query->orderBy('available_at');

        return $query->lists('uuid');
    }


    public function geographicSearch($north, $south, $west, $east, $type = null, $availability = null, $beds = null, $price = null)
    {

        $query = $this->baseSearch(false, null, null, $type, $availability, $beds, $price);

        $query->whereBetween('lat', [$south, $north]);

        $query->whereBetween('lng', [$west, $east]);

       return $query->get(['rentals.uuid', 'lat', 'lng']);

    }

    public function getRentalsByIds(array $ids)
    {
        return Rental::with('photos')->whereIn('uuid', $ids)->get();
    }

    public function locationSearch($city)
    {
        return Rental::select([ DB::raw('concat(city, ", ", province) as text'), DB::raw('location as id')])
            ->where(DB::raw('concat(city, ", ", province)'), 'like', "%$city%")
            ->where('active', 1)
            ->groupBy('location')
            ->get();
    }
/*
    public function locationSearch($city)
    {
        return Rental::select([ DB::raw('concat(city, ", ", province) as text'), DB::raw('concat(city, ", ", province) as id')])
            ->where(DB::raw('concat(city, ", ", province)'), 'like', "%$city%")
            ->groupBy('city', 'province')
            ->get();
    }
*/
    public function getRentalsForUser(User $user)
    {
        return $user->rentals;
    }

    public function find($id)
    {
        return Rental::findOrFail($id);
    }

    public function findByUUID($id)
    {
        return Rental::where('uuid', $id)->firstOrFail();
    }

    public function findRentalForUser(User $user, $id)
    {
        return Rental::where(['user_id' => $user->id, 'uuid' => $id])->firstOrFail();
    }

    public function activate(Rental $rental)
    {

        $rental->active = 1;
        $rental->activated_at = Carbon::now();

        return $rental->save();
    }

    public function deactivate(Rental $rental)
    {

        $rental->active = 0;
        $rental->activated_at = null;

        return $rental->save();
    }


    public function getActiveRentalCountForUser(User $user)
    {
        return $user->rentals()->where('active', 1)->count();
    }

    public function deactivateAllForUser(User $user)
    {
        return $user->rentals()->update(['active' => 0]);
    }


    public function getPromotedRentals(User $user)
    {
        return $user->rentals()->where(['active' => 1, 'promoted' => 1])->get();
    }

    public function getUnpromotedRentals(user $user)
    {
        return $user->rentals()->where(['active' => 1, 'promoted' => 0, 'queued' => 0])->get();
    }

    public function promoteRental(Rental $rental)
    {
        $rental->promoted = 1;
        $rental->promotion_ends_at = Carbon::now()->addDays(Config::get('promotion.days'));
        $rental->queued = 0;
        $rental->queued_at = null;

        return $rental->save();
    }

    public function unpromoteRental(Rental $rental)
    {
        $rental->promoted = 0;
        $rental->promotion_ends_at = null;

        return $rental->save();
    }

    public function getPhoneByRental(Rental $rental)
    {
        return ! is_null($rental->user->profile) ? $rental->user->profile->primary_phone : null;
    }

    public function getUserByRental(Rental $rental)
    {
        return $rental->user;
    }

    public function locationExists($location)
    {
        return Rental::where('location', $location)->take(1)->get()->count() > 0;
    }

    public function queueRental(Rental $rental)
    {
        $rental->queued = 1;
        $rental->queued_at = Carbon::now();

        return $rental->save();
    }

    public function unqueueRental(Rental $rental)
    {
        $rental->queued = 0;
        $rental->queued_at = null;

        return $rental->save();
    }

    public function delete(Rental $rental)
    {
        return $rental->delete();
    }

    public function incrementViews(Rental $rental)
    {
        return $rental->increment('views');
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
        $differentCounty = DB::table('rentals')
            ->where('city', $city)
            ->where('province', $province)
            ->where('county', '!=', $county)
            ->count();

        if($differentCounty > 0) return true;

        $alreadyDuplicate = DB::table('rentals')
            ->where('province', $province)
            ->where('county', '=', $county)
            ->where('city', '=', $city . ' ' . $county)
            ->count();

        if($alreadyDuplicate > 0) return true;

        return false;

    }

    public function incrementEmailClick(Rental $rental)
    {
        return  $rental->increment('email_click');
    }

    public function incrementPhoneClick(Rental $rental)
    {
        return  $rental->increment('phone_click');
    }
}