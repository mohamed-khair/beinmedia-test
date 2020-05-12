<?php


namespace App\Services;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class TimezoneService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://worldtimeapi.org/api/']);
    }

    private function worldMapApi($url){
        try{
            $response = $this->httpClient->get($url);
            return json_decode($response->getBody()->getcontents(), true) ?? null;
        }
        catch (ClientException $exception){
            Log::error($exception->getMessage());
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
        return null;
    }

    public function getTimezones(){
        $default_timezone = Carbon::now()->getTimezone()->getAbbr();
        $default_timezones = [$default_timezone];
        return $this->worldMapApi("timezone") ?? $default_timezones;
    }

    public function getTimezoneFromIp($ip){
        $default_timezone = Carbon::now()->getTimezone()->getAbbr();
        return $this->worldMapApi("ip/$ip") ?? $default_timezone;
    }
}
