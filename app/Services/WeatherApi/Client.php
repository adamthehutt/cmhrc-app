<?php

namespace App\Services\WeatherApi;

use App\DataObjects\WeatherDay;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Client
{
    public function fetchWeather($latitude, $longitude, $date): WeatherDay
    {
        $endpoint = "https://api.weatherapi.com/v1/history.json?key=".config("services.weather_api.key");
        $endpoint .= "&q=$latitude,$longitude";
        $endpoint .= "&dt=".Carbon::make($date)->toDateString();

        $response = Http::get($endpoint)->json();

        return $this->toWeather($response);
    }

    protected function toWeather(array $response): WeatherDay
    {
        $location = Arr::dot($response['location']);
        $day = Arr::dot($response['forecast']['forecastday'][0]);

        return new WeatherDay(
            latitude: $location['lat'],
            longitude: $location['lon'],
            location: $location['name'] . ', ' . $location['region'],
            date: $day['date'],
            tempMax: $day['day.maxtemp_f'],
            tempMin: $day['day.mintemp_f'],
            tempAvg: $day['day.avgtemp_f'],
            humidity: $day['day.avghumidity'],
            precipitation: $day['day.totalprecip_in'],
            uv: $day['day.uv'],
            sunrise: $day['astro.sunrise'],
            sunset: $day['astro.sunset'],
            moon: $day['astro.moon_phase'],
            description: $day['day.condition.text'],
            icon: $day['day.condition.icon'],
        );
    }
}