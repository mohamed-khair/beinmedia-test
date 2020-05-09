<?php

namespace App\Http\Controllers;

use App\Expert;
use App\Services\TimezoneService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    protected $timezoneService;

    public function __construct(TimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $experts = Expert::all();
        $user_tz = $this->timezoneService->getCurrentTimezone($request->ip());
        foreach ($experts as $idx => $expert){
            $expert_tz = $expert->timezone;
            $experts[$idx]["start_work"] = Carbon::createFromTimeString($expert["start_work"], $expert_tz)->setTimezone($user_tz)->format("g:i A");
            $experts[$idx]["end_work"] = Carbon::createFromTimeString($expert["end_work"], $expert_tz)->setTimezone($user_tz)->format("g:i A");
        }
        return response()->json($experts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function show(Expert $expert)
    {
        return response()->json($expert);
    }
}
