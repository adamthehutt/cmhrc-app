<?php

namespace App\DataObjects;

/**
 * NOTE:
 * temperatures in Farenheit
 * precipitation in inches
 */
class WeatherDay implements \JsonSerializable
{
    public function __construct(
        public mixed $latitude = null,
        public mixed $longitude = null,
        public mixed $location = null,
        public mixed $date = null,
        public mixed $tempMax = null,
        public mixed $tempMin = null,
        public mixed $tempAvg = null,
        public mixed $humidity = null,
        public mixed $precipitation = null,
        public mixed $uv = null,
        public mixed $sunrise = null,
        public mixed $sunset = null,
        public mixed $moon = null,
        public mixed $description = null,
        public mixed $icon = null,
    ) {}

    public function tempVariation()
    {
        return bcsub((string) $this->tempMax, (string) $this->tempMin, 1);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}