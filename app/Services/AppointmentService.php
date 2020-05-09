<?php


namespace App\Services;


use App\Appointment;
use App\Expert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function getAvailableTimeSlots($expert_id, $duration, $date, $timezone)
    {
        $appointments = Appointment::where(DB::raw("DATE(start) = '${date}'"))->sortBy("start")->get();
        $expert = Expert::find($expert_id);
        if(!$expert)
            return [];
        $start_work = Carbon::createFromFormat("Y-m-d H:i:s", "${date} {$expert->start_work}", $timezone);
        $end_work = Carbon::createFromFormat("Y-m-d H:i:s", "${date} {$expert->end_work}", $timezone);
        $slots = [];
        $time_starts = $this->rangeToSlots($start_work, $end_work, (int)$duration);
        $currentAppointment = 0;


    }

}
