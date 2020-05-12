<?php

namespace App\Http\Controllers;

use App\Expert;
use App\Services\TimezoneService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    protected $timezoneService;

    public function __construct(TimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }

    /**
     * Display a listing of the experts.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $experts = Expert::all();
        $client_ip = $request->getClientIp();
        $client_timezone = $this->timezoneService->getTimezoneFromIp($client_ip);
        $time_format = "g:i A";

        foreach ($experts as $idx => $expert){
            $expert_timezone = $expert->timezone;
            $start_work_time = Carbon::createFromTimeString($expert["start_work"], $expert_timezone);
            $end_work_time = Carbon::createFromTimeString($expert["end_work"], $expert_timezone);
            $expert["start_work"] = $start_work_time->format($time_format);
            $expert["end_work"] = $end_work_time->format($time_format);
            $expert["start_work_locale"] = $start_work_time->setTimezone($client_timezone)->format($time_format);
            $expert["end_work_locale"] = $end_work_time->setTimezone($client_timezone)->format($time_format);
        }

        return response()->json($experts);
    }

    /**
     * Display the specified expert.
     *
     * @param Expert $expert
     * @return JsonResponse
     */
    public function show(Expert $expert)
    {
        return response()->json($expert);
    }
}
