<?php

namespace App\Http\Controllers;

use App\Services\TimezoneService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimezoneController extends Controller
{
    protected $timezoneService;

    public function __construct(TimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }

    /**
     * Get all global timezones in the world
     *
     * @return JsonResponse
     */
    public function getAllTimezones()
    {
        $timezones = $this->timezoneService->getTimezones();
        return response()->json($timezones);
    }

    /**
     * Get the user timezone based on his IP address
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCurrentUserTimezone(Request $request)
    {
        $client_ip = $request->ip();
        $timezone = $this->timezoneService->getTimezoneFromIp($client_ip);
        return response()->json($timezone);
    }
}
