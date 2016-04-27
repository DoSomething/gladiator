<?php

namespace Gladiator\Http\Requests;

class SplitRequest extends Request
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
            'competition_end_date' => 'required|date|after:today',
            'leaderboard_msg_day' => 'required',
            'rules_url' => 'required|url',
            'competition_max' => 'required|numeric',
        ];
    }
}
