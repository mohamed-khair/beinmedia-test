<?php


namespace App\Services;


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

    private function sendHttpRequest($url){
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
        $serverTimezone = config("timezone", "Asia/Dubai");
        $timezones = [$serverTimezone];
        return $this->sendHttpRequest("timezone") ?? $timezones;
    }

    public function getCurrentTimezone($ip){
        $timezone = config("timezone", "Asia/Dubai");
        return $this->sendHttpRequest("ip/$ip")["timezone"] ?? $timezone;
    }
}
