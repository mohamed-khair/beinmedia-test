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
        //
    }

    public function availableTimeSlots(Request $request){
        $data = $request->all();
    }
}
