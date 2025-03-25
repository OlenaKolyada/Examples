<?php

declare(strict_types=1);

namespace App\Weather;

use App\View;

class WeatherController extends View
{
    private Weather $weather;
    private WeatherView $weatherView;

    public function __construct()
    {
        $this->weather = new Weather();
        $this->weatherView = new WeatherView();
    }

    // Get Weather
    public function getWeather(): void
    {
        $city = $_POST['city'] ?? null;

        if ($city) {
            $city = ucfirst(strtolower($city));
            $data = $this->weather->fetchWeather($city);
            $this->renderWeather($data, $city);
            $_SESSION['last_city'] = $city;
            $_SESSION['weather_data'] = $data;
        }
    }

    // Display Weather
    private function renderWeather($data, $city): void
    {
        $this->weatherView->displayWeather($data, $city);
    }
}
