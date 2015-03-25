<?php namespace RentGorilla\Repositories;

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

    public function search($city = null, $province = null, $type = null, $availability = null, $beds = null, $price = null)
    {
        $query = $this->baseSearch(true, $city, $province, $type, $availability, $beds, $price);

        $query->orderBy('available_at');

        return $query->paginate(12);
    }

    public function geographicSearch($north, $south, $west, $east, $type = null, $availability = null, $beds = null, $price = null)
    {

        $query = $this->baseSearch(false, null, null, $type, $availability, $beds, $price);

        $query->whereBetween('lat', [$south, $north]);

        $query->whereBetween('lng', [$west, $east]);

       return $query->get(['rentals.id', 'lat', 'lng']);

    }

    public function getRentalsByIds(array $ids)
    {
        return Rental::with('photos')->whereIn('id', $ids)->get();
    }

    public function locationSearch($city)
    {
        return Rental::select([ DB::raw('concat(city, ", ", province) as text'), DB::raw('concat(city, ", ", province) as id')])
            ->where(DB::raw('concat(city, ", ", province)'), 'like', "%$city%")
            ->groupBy('city', 'province')
            ->get();
    }

    public function getRentalsForUser(User $user)
    {
        return $user->rentals;
    }

    public function find($id)
    {
        return Rental::findOrFail($id);
    }

    public function findRentalForUser(User $user, $id)
    {
        return Rental::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();
    }

    public function activate($rental_id)
    {
        $rental = $this->find($rental_id);

        $rental->active = 1;

        return $rental->save();
    }

    public function deactivate($rental_id)
    {
        $rental = $this->find($rental_id);

        $rental->active = 0;

        return $rental->save();
    }

    public function getActiveRentalCountForUser(User $user)
    {
        return $user->rentals()->where('active', 1)->count();
    }
}