<?php

namespace RentGorilla\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Services\Signature\Signature;

class SignedController extends Controller
{
    /**
     * @var Signature
     */
    protected $signature;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    /**
     * SignedController constructor.
     * @param Signature $signature
     * @param RentalRepository $rentalRepository
     */
    public function __construct(Signature $signature, RentalRepository $rentalRepository)
    {
        $this->signature = $signature;
        $this->rentalRepository = $rentalRepository;
    }

    public function modifyAvailability($uuid, $signature)
    {
        if(! $this->signature->validate([$uuid], $signature))
        {
            app()->abort(404);
        }

        $rental = $this->rentalRepository->findByUUID($uuid);

        Auth::login($rental->user);

        return redirect()->route('rental.availability.edit', ['rental' => $uuid]);
    }
}