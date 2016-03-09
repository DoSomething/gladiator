<?php

namespace Gladiator\Http\Requests;

class WaitingRoomRequest extends Request
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
        if ($this->wantsJson()) {
            return [
                'contest_id' => 'required|numeric',
            ];
        } else {
            return [
                'contest_id' => 'required|numeric',
                'signup_start_date' => 'required|date',
                'signup_end_date' => 'required|date',
            ];
        }
    }
}
