<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $appointment = $this->appointmentService->storeAppointment($data["expert_id"], $data["client_name"], $data["date"], $data["start_time"], $data["end_time"], $data["timezone"]);

        if($appointment)
            return response()->json($appointment);
        return response()->setStatusCode(400);
    }

    public function availableTimeSlots(Request $request){
        $data = $request->all();
        $slots = $this->appointmentService->getAvailableTimeSlots($data["expert_id"], $data["duration"], $data["date"], $data["timezone"]);
        return response()->json($slots);
    }
}
