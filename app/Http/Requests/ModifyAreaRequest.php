<?php

namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Config;

class ModifyAreaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //see https://stackoverflow.com/questions/29093061/composite-unique-key-validation-laravel
        return [
            'name' => [
                'required',
                'unique:areas,name,NULL,id,province,'. $this->province
            ],
            'province' => [
                'required',
                'in:' . implode(',', array_keys(Config::get('rentals.provinces'))),
                'unique:areas,province,NULL,id,name,'. $this->name
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The combination of name and province must be unique.',
            'province.unique' => 'The combination of name and province must be unique.'
        ];
    }
}
