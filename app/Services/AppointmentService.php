<?php


namespace App\Services;


use App\Appointment;
use App\Expert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\Precision;

class AppointmentService
{
    public function storeAppointment($expert_id, $client_name, $date, $start_time, $end_time, $timezone)
    {
        if(!$this->validation($expert_id, $date, $start_time, $end_time, $timezone)){
            return null;
        }
        $start = Carbon::parse("$date $start_time", $timezone);
        $end = Carbon::parse("$date $end_time", $timezone);
        return Appointment::create([
           "start" => $start->toDateTimeString(),
           "end" => $end->toDateTimeString(),
            "client_name" => $client_name,
            "expert_id" => $expert_id,
        ]);
    }

    public function getAvailableTimeSlots($expert_id, $duration, $date, $timezone)
    {
        $appointments = Appointment::where("expert_id", $expert_id)
            ->whereRaw(DB::raw("DATE(start) = '${date}'"))->orderBy("start")->get();
        $expert = Expert::find($expert_id);
        $expert_timezone = $expert->timezone;
        if(!$expert)
            return [];
        $start_work = Carbon::createFromFormat("Y-m-d H:i:s", "${date} {$expert->start_work}", $expert_timezone);
        $end_work = Carbon::createFromFormat("Y-m-d H:i:s", "${date} {$expert->end_work}", $expert_timezone);
        $slots = [];
        $time_starts = $this->rangeToSlots($start_work, $end_work, (int)$duration);
        $appointments_periods = [];
        foreach ($appointments as $appointment){
            $appointment_start = Carbon::parse($appointment->start, $expert_timezone)->toDateTimeImmutable();
            $appointment_end = Carbon::parse($appointment->end, $expert_timezone)->toDateTimeImmutable();
            $appointment_period = new Period($appointment_start, $appointment_end, Precision::MINUTE, Boundaries::EXCLUDE_END);
            array_push($appointments_periods, $appointment_period);
        }

        foreach ($time_starts as $time_start){
            $available = true;
            foreach ($appointments_periods as $appointments_period){
                if($time_start->overlapsWith($appointments_period)){
                    $available = false;
                    break;
                }
            }
            if($available){
                array_push($slots, [
                    "start" => Carbon::parse($time_start->getStart(), $timezone)->format("H:i"),
                    "end" => Carbon::parse($time_start->getEnd(), $timezone)->format("H:i")
                ]);
            }
        }
        return $slots;
    }

    private function validation($expert_id, $date, $start_time, $end_time, $timezone){
        $start = Carbon::createFromTimeString($start_time, $timezone);
        $end = Carbon::createFromTimeString($end_time, $timezone);
        $slots = $this->getAvailableTimeSlots($expert_id, $end->diffInMinutes($start), $date, $timezone);
        $selected_range = [
            "start" => $start->format("H:i"),
            "end" => $end->format("H:i")
        ];
        $slot_found = false;
        foreach($slots as $slot) {
            if ($selected_range["start"] == $slot["start"] && $selected_range["end"] == $slot["end"]) {
                $slot_found = true;
                break;
            }
        }
        return $slot_found;
    }

    /**
     * @param $start_work
     * @param $end_work
     * @param $duration
     * @return array[Period]
     */
    private function rangeToSlots($start_work, $end_work, $duration)
    {
        $start = Carbon::parse($start_work);
        $end = Carbon::parse($end_work);
        $slots = [];

        while($end->diffInMinutes($start) >= $duration){
            $new_start = $start->clone();
            $new_start->addMinutes($duration);
            array_push($slots, new Period($start->toDateTimeImmutable(), $new_start->toDateTimeImmutable(), Precision::MINUTE, Boundaries::EXCLUDE_END));
            $start = $new_start;
        }
        return $slots;
    }
}
