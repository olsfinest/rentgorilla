<?php namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;

class EmailManagerRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'rental_id' => 'required'
		];
	}

    public function messages()
    {
        return [
            'fname.required' => 'The first name field is required',
            'lname.required' => 'The last name field is required',
        ];
    }

}
