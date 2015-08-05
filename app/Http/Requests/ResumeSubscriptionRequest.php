<?php namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Auth;

class ResumeSubscriptionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check() && $this->user()->cancelled() && $this->user()->subscribed();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}

}
