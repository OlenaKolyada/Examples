<?php

declare(strict_types=1);

namespace App\Weather;

class WeatherView
{
    // Display Weather
    public function displayWeather(array $data, string $city): void
    {
        $content = 'App/Weather/templates/weather.html';
        $pageTitle = "Weather in $city";
        include 'templates/layout.html';
    }
}
