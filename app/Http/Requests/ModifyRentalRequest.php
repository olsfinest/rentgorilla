<?php namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Auth;
use Config;

class ModifyRentalRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
            'street_address' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|in:' . implode(',', array_keys(Config::get('rentals.provinces'))),
            'type' => 'required|in:' . implode(',', array_keys(Config::get('rentals.type'))),
            'beds' => 'required|integer',
            'price' => 'required|integer',
            'deposit' => 'required|integer',
            'laundry' => 'required|in:' . implode(',', array_keys(Config::get('rentals.laundry'))),
            'disability_access' => 'required|boolean',
            'smoking' => 'required|boolean',
            'utilities_included' => 'required|boolean',
            'heat_included' => 'required|boolean',
            'furnished' => 'required|boolean',
            'square_footage' => 'integer',
            'available' => 'required|date_format:m/d/Y',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'pets' => 'required|in:' . implode(',', array_keys(Config::get('rentals.pets'))),
            'baths' => 'required|numeric',
            'lease' => 'required|integer',
            'video' => 'url',
            'postal_code' => 'max:7',
            'active' => 'boolean'
        ];

        if($this->request->get('feature_list')) {

            foreach ($this->request->get('feature_list') as $key => $val) {
                $rules['feature_list.' . $key] = 'integer';
            }
        }

        if($this->request->get('appliance_list')) {

            foreach ($this->request->get('appliance_list') as $key => $val) {
                $rules['appliance_list.' . $key] = 'integer';
            }
        }

        if($this->request->get('heat_list')) {

            foreach ($this->request->get('heat_list') as $key => $val) {
                $rules['heat_list.' . $key] = 'integer';
            }
        }

        return $rules;
	}

}
