<?php

namespace Linder\Model;

use OpenCage\Geocoder\AbstractGeocoder;

class Coordinates
{
    private $geocoder;

    /**
     * Constructor, allow for $geocoder to be injected.
     *
     * @param $geocoder a service that fetches coordinates from a query
     */
    public function __construct(AbstractGeocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * This method checks if a input is a valid lat long
     * If not it does a search on it and returns the answer.
     *
     * @param string $value
     *
     * @return string
     */
    public function getCoordinates(String $search) : String
    {
        $valid = preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $search);
        if (!$valid) {
            $result = $this->geocoder->geocode($search);
            if ($result["status"]["code"] == 400) {
                return "";
            }
            $search = $result["results"][0]["geometry"]["lat"] . "," . $result["results"][0]["geometry"]["lng"];
        }

        return $search;
    }
}
