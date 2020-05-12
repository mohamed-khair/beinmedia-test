<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\FindAvailableTimeSlotsRequest;
use App\Http\Requests\ScheduleAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Schedule new appointment
     *
     * @param ScheduleAppointmentRequest $request
     * @return Application|ResponseFactory|JsonResponse|Response|object
     */
    public function store(ScheduleAppointmentRequest $request)
    {
        extract($request->all());
        $appointment = $this->appointmentService->storeAppointment($expert_id, $client_name, $date, $start_time, $end_time, $timezone);

        if($appointment)
            return response()->json($appointment);

        return response()->setStatusCode(400, "Couldn't schedule your desired appointment, please try again.");
    }

    /**
     * Get available time slots for scheduling a new appointment
     *
     * @param FindAvailableTimeSlotsRequest $request
     * @return JsonResponse
     */
    public function slots(FindAvailableTimeSlotsRequest $request){
        extract($request->all());
        $slots = $this->appointmentService->getAvailableTimeSlots($expert_id, $duration, $date, $timezone);
        return response()->json($slots);
    }
}
