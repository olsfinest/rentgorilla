<?php

namespace RentGorilla\Http\Requests;

use RentGorilla\Http\Requests\Request;
use Auth;

class ModifyLandingPageRequest extends Request
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
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        if ($this->request->has('hrefs')) {
            foreach ($this->request->get('hrefs') as $key => $val) {
                $rules['hrefs.' . $key] = 'required|url';
                $rules['titles.' . $key] = 'required';
            }
        }

        if ($this->request->has('titles')) {
            foreach ($this->request->get('titles') as $key => $val) {
                $rules['titles.' . $key] = 'required';
                $rules['hrefs.' . $key] = 'required|url';
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        if ($this->request->has('hrefs')) {
            foreach ($this->request->get('hrefs') as $index => $href) {
                $key = 'hrefs.' . $index;
                $messages[$key . '.required'] = 'The link is required';
                $messages[$key . '.url'] = 'The link must be a valid URL';
            }
        }

        if ($this->request->has('titles')) {
            foreach ($this->request->get('titles') as $index => $title) {
                $key = 'titles.' . $index;
                $messages[$key . '.required'] = 'The title is required';
            }
        }

        return $messages;
    }
}
