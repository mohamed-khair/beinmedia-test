<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleAppointmentRequest extends FormRequest
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
            "client_name" => ["required", "string"],
            "expert_id" => ["required", "integer", "exists:experts,id"],
            "date" => ["required", "date"],
            "start_time" => ["required", "regex:/(\d+\:\d+)/"],
            "end_time" => ["required", "regex:/(\d+\:\d+)/"],
            "timezone" => ["required", "string"]
        ];
    }
}
