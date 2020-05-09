<?php

namespace App\Http\Controllers;

use App\Services\TimezoneService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimezoneController extends Controller
{
    protected $timezoneService;

    public function __construct(TimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }

    public function getAllTimezones()
    {
        $serverTimezone = config("timezone", "Asia/Dubai");
        $timezones = $this->timezoneService->getTimezones() ?? [$serverTimezone];
        return response()->json($timezones);
    }

    public function getCurrentUserTimezone(Request $request)
    {
        $serverTimezone = config("timezone", "Asia/Dubai");
        $timezone = $this->timezoneService->getCurrentTimezone($request->getClientIp())["timezone"] ?? $serverTimezone;
        return response()->json($timezone);
    }
}
