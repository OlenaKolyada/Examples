<?php

declare(strict_types=1);

namespace App\Weather;

class Weather
{
    private string $apiUrl = 'https://www.prevision-meteo.ch/services/json/';

    // Getting Data From API
    public function fetchWeather(string $city): ?array
    {
        $url = $this->apiUrl . urlencode($city);
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return $data;
    }
}