<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class CreateRentalCommand extends Command {

    public $user_id;
    public $street_address;
    public $city;
    public $county;
    public $province;
    public $type;
    public $pets;
    public $parking;
    public $baths;
    public $beds;
    public $price;
    public $per_room;
    public $deposit;
    public $laundry;
    public $disability_access;
    public $smoking;
    public $utilities_included;
    public $heat_included;
    public $furnished;
    public $square_footage;
    public $available;
    public $lat;
    public $lng;
    public $lease;
    public $description;
    public $video;
    public $feature_list;
    public $appliance_list;
    public $heat_list;
    public $postal_code;
    public $active;

    function __construct($user_id, $street_address, $city, $county, $province, $type, $pets, $parking, $baths, $beds, $price, $deposit, $laundry, $disability_access, $smoking, $utilities_included, $heat_included, $furnished, $available, $lat, $lng, $lease, $description, $video, $per_room = null, $active = null, $square_footage = null, $feature_list = null,  $appliance_list = null, $heat_list = null, $postal_code = null)
    {
        $this->user_id = $user_id;
        $this->street_address = $street_address;
        $this->city = $city;
        $this->county = $county;
        $this->province = $province;
        $this->type = $type;
        $this->pets = $pets;
        $this->parking = $parking;
        $this->baths = $baths;
        $this->beds = $beds;
        $this->price = $price;
        $this->per_room = $per_room;
        $this->deposit = $deposit;
        $this->laundry = $laundry;
        $this->disability_access = $disability_access;
        $this->smoking = $smoking;
        $this->utilities_included = $utilities_included;
        $this->heat_included = $heat_included;
        $this->furnished = $furnished;
        $this->square_footage = $square_footage;
        $this->available = $available;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->lease = $lease;
        $this->description = $description;
        $this->video = $video;
        $this->feature_list = $feature_list;
        $this->appliance_list = $appliance_list;
        $this->heat_list = $heat_list;
        $this->postal_code = $postal_code;
        $this->active = $active;
    }


}
