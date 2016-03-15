<?php

namespace Gladiator\Http\Requests;

class ContestRequest extends Request
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
        return [
            'campaign_id' => 'required|numeric',
            'campaign_run_id' => 'required|numeric',
            'duration' => 'required|numeric',
            'signup_start_date' => 'required|date',
            'signup_end_date' => 'required|date',
        ];
    }
}
