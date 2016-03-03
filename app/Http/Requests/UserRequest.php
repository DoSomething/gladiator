<?php

namespace Gladiator\Http\Requests;

class UserRequest extends Request
{
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
        dd('checking');

        $rules = [
            'key' => 'required',
            'type' => 'required',
            'campaign_id' => 'numeric',
            'campaign_run_id' => 'numeric',
        ];

        if ($this->ajax()) {
            return $rules;
        }

        $rules['role'] = 'required';

        return $rules;
    }
}
