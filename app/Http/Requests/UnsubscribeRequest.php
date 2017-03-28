<?php

namespace Gladiator\Http\Requests;

class UnsubscribeRequest extends Request
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
        $rules = [
            'northstar_id' => 'required',
            'competition_id' => 'required',
        ];

        return $rules;
    }
}
