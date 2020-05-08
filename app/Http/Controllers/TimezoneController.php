<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimezoneController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://worldtimeapi.org/api/']);
    }

    public function getAllTimezones()
    {
        $serverTimezone = config("timezone", "Asia/Dubai");
        $timezones = [$serverTimezone];
        try{
            $response = $this->httpClient->get("timezone");
            $timezones = json_decode($response->getBody()->getcontents(), true);
        }
        catch (ClientException $exception){
            Log::error($exception->getMessage());
        }
        return response()->json($timezones);
    }

    public function getCurrentUserTimezone(Request $request)
    {
        $timezone = config("timezone", "Asia/Dubai");
        try{
            $response = $this->httpClient->get("ip/".$request->ip());
            $timezone = json_decode($response->getBody()->getcontents(), true)["timezone"];
        }
        catch (ClientException $exception){
            Log::error($exception->getMessage());
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
        return response()->json($timezone);
    }
}
