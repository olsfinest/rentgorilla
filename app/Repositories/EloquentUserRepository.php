<?php namespace RentGorilla\Repositories;

use Illuminate\Support\Facades\DB;
use RentGorilla\User;

class EloquentUserRepository implements UserRepository
{

    /**
     * Find a user by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }


    /**
     * Gets an array of rental ids that a given User has favourited
     *
     * @param $user \RentGorilla\User
     * @return array
     */
    public function getFavouriteRentalIdsForUser(User $user)
    {
        return $user->favourites->lists('id')->all();
    }

    /**
     * Saves the model
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {
        return $user->save();
    }

    /**
     * Gets a user by a column attribute
     *
     * @param $attribute
     * @param $searchTerm
     * @return mixed
     */
    public function getUserByAttribute($attribute, $searchTerm)
    {
        return User::where($attribute, $searchTerm)->firstOrFail();
    }

    /**
     * Confirms a user
     *
     * @param User $user
     * @return User
     */
    public function confirm(User $user)
    {
        $user->confirmed = 1;

        $user->confirmation = null;

        $user->save();

        return $user;
    }

    public function getPhotoLikesForUser(User $user)
    {
        return $user->likes->lists('photo_id')->all();
    }

    public function awardPoints(User $user, $points)
    {
        $user->points = $user->points + $points;

        return $user->save();
    }

    public function redeemPoints(User $user)
    {
        $pointsToSubtract = $user->getPointsReadyToRedeem();

        if($pointsToSubtract) {
            $user->points = $user->points - $pointsToSubtract;
            return $user->save();
        } else {
            return false;
        }
    }

    public function emailSearch($email)
    {
        return User::select([ DB::raw('email as text'), DB::raw('id')])
            ->where('email', 'like', "%$email%")
            ->get();
    }

    public function getPaginated(array $params)
    {

        if($this->isSortable($params)) {

            return User::leftJoin('rentals',  function ($join) {
                $join->on('users.id', '=', 'rentals.user_id')
                    ->where('rentals.active', '=', 1);
            })
            ->selectRaw('users.*, count(rentals.user_id) as rentalsCount')
            ->groupBy('users.id')
            ->orderBy($params['sortBy'], $params['direction'])->paginate(10);
        }

        return User::leftJoin('rentals',  function ($join) {
            $join->on('users.id', '=', 'rentals.user_id')
                ->where('rentals.active', '=', 1);
        })
        ->selectRaw('users.*, count(rentals.user_id) as rentalsCount')
        ->groupBy('users.id')
        ->orderBy('email')
        ->paginate(10);


    }

    /**
     * @param array $params
     * @return bool
     */
    private function isSortable(array $params)
    {
        return $params['sortBy'] && $params['direction'];
    }

    public function delete($id)
    {
        return User::where('id', $id)->delete();
    }

    public function reconfirm(User $user)
    {
        $user->confirmation = str_random(40);

        $user->save();

        return $user;
    }
}