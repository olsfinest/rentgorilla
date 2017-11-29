<?php

namespace RentGorilla\Http\Requests;

use Auth;
use RentGorilla\Http\Requests\Request;

class RentalAvailabilityRequest extends Request
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
        $rules = [
            'date' => 'required|in:deactivate,today,month,year,custom'
        ];

        if($this->request->get('date') === 'custom') {
            $rules['available'] = 'required|date_format:m/d/Y|date|after:today';
        }

        return $rules;
    }

    public function messages()
    {
       return [
            'date.required' => 'Please select an option.',
            'available.after' => 'Please select a date after today'
           ];
    }
}
