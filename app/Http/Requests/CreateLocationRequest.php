<?php

namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Auth;

class CreateLocationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => 'required',
            'province' => 'required',
            'zoom' => 'required',
            'county' => 'sometimes|required'
        ];
    }
}
