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
        // @TODO: check authorization?
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
            'key' => 'required',
            'type' => 'required',
            'role' => 'required',
            'campaign_id' => 'numeric',
            'campaign_run_id' => 'numeric',
        ];
    }
}
