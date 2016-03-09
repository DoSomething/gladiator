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
        $rules = [
            'id' => 'required',
            'term' => 'required',
        ];

        if ($this->wantsJson()) {
            $rules += [
                'campaign_id' => 'required|numeric',
                'campaign_run_id' => 'required|numeric',
            ];

            return $rules;
        }

        $rules += [
            'role' => 'required',
        ];

        return $rules;
    }
}
