<?php

namespace Gladiator\Http\Requests;

use Gladiator\Http\Requests\Request;
use Gladiator\Models\Competition;

class StoreCompetitionRequest extends Request
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }

}
