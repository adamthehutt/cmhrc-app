<?php

namespace App\Services\OpenWeather;

use Illuminate\Support\Facades\Http;

class Client
{
    const BASE_ENDPOINT = 'https://api.openweathermap.org/data/3.0/onecall/timemachine';

    const PARAM_LATITUDE = 'lat';

    const PARAM_LONGITUDE = 'lon';

    const PARAM_UNIXTIME = 'dt';

    const PARAM_LANG = 'lang';

    const PARAM_UNITS = 'units';

    const PARAM_KEY = 'appid';

    public function fetchWeather(array $params): array
    {
        $params = array_merge([
            static::PARAM_UNIXTIME => time(),
            static::PARAM_LANG => 'en',
            static::PARAM_UNITS => 'imperial',
            static::PARAM_KEY => config("services.open_weather.key"),
        ], $params);

        if (! isset($params[static::PARAM_LATITUDE], $params[static::PARAM_LONGITUDE])) {
            throw new \RuntimeException("Latitude and longitude are required");
        }

        $url = static::BASE_ENDPOINT . '?' . http_build_query($params);

        return Http::get($url)->json();
    }
}