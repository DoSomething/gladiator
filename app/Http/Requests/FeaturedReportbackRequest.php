<?php

namespace Gladiator\Http\Requests;

class FeaturedReportbackRequest extends Request
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
            'reportback_id' => 'required|numeric',
            'reportback_item_id' => 'required|numeric',
            'shoutout' => 'required|string',
        ];
    }
}
