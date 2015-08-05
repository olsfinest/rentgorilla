<?php namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Auth;

class PromoteRentalRequest extends Request {

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
			'rental_id' => 'required|exists:rentals,uuid,promoted,0',

		];

        if( ! $this->user()->readyForBilling()) {
            $rules['stripe_token'] = 'required';
        }

        return $rules;
	}

    public function messages()
    {
        return [
            'rental_id.exists' => 'The rental must be found and not already promoted',
        ];
    }

}
