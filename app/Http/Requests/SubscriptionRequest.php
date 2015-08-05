<?php namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;

use Auth;

class SubscriptionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check() && ! $this->user()->stripeIsActive();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
    {
        if ( ! $this->user()->readyForBilling()) {
            return [
                'stripe_token' => 'required'
            ];
        } else {
            return [];
        }
    }
}
