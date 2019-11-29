<?php

namespace Linder\Mock;

use OpenCage\Geocoder\AbstractGeocoder;

class GeocoderMock extends AbstractGeocoder
{
    /**
     * This method mocks OpenCage API
     * and only returns the Latitude and Longitude
     * of gothenburg which is default value
     * and status code if it fails or not.
     *
     * @param string $value
     *
     * @return string
     */
    public function geocode($search) : Array
    {
        $res = [];

        if ($search != "fail") {
            $res["results"][0]["geometry"]["lat"] = 57.708870;
            $res["results"][0]["geometry"]["lng"] = 11.974560;
            $res["status"]["code"] = 200;
        } else {
            $res["status"]["code"] = 400;
        }

        return $res;
    }
}
