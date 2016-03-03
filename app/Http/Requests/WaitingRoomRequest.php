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
        if (ajax()) {
            return [
                'campaign_id' => 'numeric',
            ];
        }
        else {
            return [
                'key' => 'required',
                'type' => 'required',
                'role' => 'required',
                'campaign_id' => 'numeric',
                'campaign_run_id' => 'numeric',
            ];
        }
    }
}
