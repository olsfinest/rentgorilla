<?php namespace RentGorilla\Http\Requests;

use Auth;
use RentGorilla\Http\Requests\Request;

class ModifyProfileRequest extends Request
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
            'website' => 'url',
            'photo' => 'image|max:10000',
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'string',
            'accepts_texts' => 'boolean',
        ];
    }
}
