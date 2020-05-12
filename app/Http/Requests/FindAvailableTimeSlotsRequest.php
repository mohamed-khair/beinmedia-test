<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindAvailableTimeSlotsRequest extends FormRequest
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
            "expert_id" => ["required", "integer", "exists:experts,id"],
            "duration" => ["required", "integer"],
            "date" => ["required", "date"],
            "timezone" => ["required", "string"]
        ];
    }
}
