<?php namespace RentGorilla\Repositories;

use Config;
use DB;
use Carbon\Carbon;
use RentGorilla\Promotion;
use RentGorilla\Rental;
use RentGorilla\User;
use Log;

class EloquentRentalRepository implements RentalRepository
{

    protected function baseSearch($photos, $location_id = null, $type = null, $availability = null, $beds = null, $price = null)
    {

       if($photos) {
           $query = Rental::with('photos');
       } else {
           $query = DB::table('rentals');
       }
        $query->where('active', 1);

        if($location_id)
        {
            $query->where('location_id', '=', $location_id);
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
          //  $query->where('available_at', '<=', Carbon::today());
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

    public function search($page = 1, $paginate = false, $location_id = null, $type = null, $availability = null, $beds = null, $price = null, $sort = null)
    {
        $count = $this->baseSearch(false, $location_id, $type, $availability, $beds, $price)->count();

        $totalPages = ceil($count / Rental::RESULTS_PER_PAGE);

        if($sort) {
            $sort = getSortComponents($sort);
            $query = $this->baseSearch(true, $location_id, $type, $availability, $beds, $price)->orderBy('promoted', 'desc')->orderBy($sort[0], $sort[1]);
        } else {
            $query = $this->baseSearch(true, $location_id, $type, $availability, $beds, $price)->orderBy('promoted', 'desc')->orderBy('available_at');
        }

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

    public function uuids($location_id = null, $type = null, $availability = null, $beds = null, $price = null, $sort = null)
    {
        $query = $this->baseSearch(true, $location_id, $type, $availability, $beds, $price);

        if($sort) {
            $sort = getSortComponents($sort);
            $query->orderBy('promoted', 'desc')->orderBy($sort[0], $sort[1]);
        } else {
            $query->orderBy('promoted', 'desc')->orderBy('available_at');
        }

        return $query->lists('uuid')->all();
    }


    public function geographicSearch($north, $south, $west, $east, $type = null, $availability = null, $beds = null, $price = null)
    {

        $query = $this->baseSearch(false, null, $type, $availability, $beds, $price);

        $query->whereBetween('lat', [$south, $north]);

        $query->whereBetween('lng', [$west, $east]);

       return $query->get(['rentals.uuid', 'lat', 'lng']);

    }

    public function getRentalsByIds(array $ids)
    {
        return Rental::with('photos')->whereIn(DB::raw('BINARY `uuid`'), $ids)->get();
    }

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
        return Rental::where(DB::raw('BINARY `uuid`'), $id)->firstOrFail();
    }

    public function findRentalForUser(User $user, $id)
    {
        return Rental::where(DB::raw('BINARY `uuid`'), $id)->where('user_id' , $user->id)->firstOrFail();
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
       // $rental->activated_at = null;

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

        $rental->save();

        Promotion::create(['user_id' => $rental->user_id]);
    }

    public function unpromoteRental(Rental $rental)
    {
        $rental->promoted = 0;
        $rental->promotion_ends_at = null;
        $rental->free_promotion = 0;
        $rental->queued = 0;
        $rental->queued_at = null;

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

    public function incrementEmailClick(Rental $rental)
    {
        return $rental->increment('email_click');
    }

    public function incrementPhoneClick(Rental $rental)
    {
        return $rental->increment('phone_click');
    }

    public function downgradePlanCapacityForUser(User $user, $capacity)
    {

        Log::info('active rentals downgraded to '. $capacity, ['user_id' => $user->id]);

        // toggle them all off first ...
        DB::table('rentals')
            ->where('user_id', $user->id)
            ->update(['active' => 0]);

        // then activate only up to the new plans capacity
        return DB::update(DB::raw("UPDATE rentals SET active = 1 WHERE user_id = {$user->id} ORDER BY edited_at DESC LIMIT {$capacity}"));
    }

    public function updateSearchViews($rentalIds)
    {
        return DB::table('rentals')->whereIn('id', $rentalIds)->increment('search_views');
    }

    public function updateEditedAt(Rental $rental)
    {
        $rental->edited_at = Carbon::now();

        return $rental->save();
    }

    public function addressSearch($address)
    {
        return Rental::join('locations', 'locations.id', '=', 'rentals.location_id')
            ->select([ DB::raw('concat(street_address, " (", city, ")") as text'), DB::raw('user_id as id')])
            ->where('street_address', 'like', "%$address%")
            ->get();
    }

    public function freePromotion(Rental $rental)
    {
        $rental->free_promotion = 1;

        return $rental->save();
    }

    public function freePromotionAddressSearch($address, $locationId)
    {
        return Rental::select([ DB::raw('street_address as text'), DB::raw('uuid as id')])
            ->where('street_address', 'like', "%$address%")
            ->where('location_id', $locationId)
            ->where('promoted', 0)
            ->where('queued', 0)
            ->get();
    }
}
