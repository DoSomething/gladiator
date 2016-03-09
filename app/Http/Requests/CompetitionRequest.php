<?php

namespace Gladiator\Http\Requests;

class CompetitionRequest extends Request
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
            'contest_id' => 'required|numeric',
            'competition_start_date' => 'required|date',
            'competition_end_date' => 'required|date',
        ];
    }
}
