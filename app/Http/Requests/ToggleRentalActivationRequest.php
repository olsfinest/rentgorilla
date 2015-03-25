<?php namespace RentGorilla\Http\Requests;

use Auth;
use RentGorilla\Http\Requests\Request;

class ToggleRentalActivationRequest extends Request
{
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
        return [
            'rental_id' => 'required|integer'
        ];
    }
}
