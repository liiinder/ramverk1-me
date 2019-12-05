<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Linder\Model\Coordinates;
use Linder\Model\DarkSky;

/**
 * A controller that handles a get request
 * and returns if its a valid ip or not.
 */
class WeatherAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     *
     * @return object
     */
    public function indexAction() : array
    {
        $search = $this->di->get("request")->getGet("search");

        if (filter_var($search, FILTER_VALIDATE_IP)) {
            $res = $this->di->get("ipverifier")->getJson($search);
            $latlon = ((!$res["latitude"]) || (!$res["longitude"])) ? "" : $res["latitude"] . "," . $res["longitude"];
        } else if ($search) {
            $geocoder = $this->di->get("geocoder");
            $coords = new Coordinates($geocoder);
            $latlon = $coords->getCoordinates($search);
        }
        if (($search) && ($latlon != "")) {
            $darksky = $this->di->get("darksky");
            $type = $this->di->get("request")->getGet("type");
            if ($type == "past") {
                $res = $darksky->getWeatherPast($latlon);
            } else {
                $res = $darksky->getWeatherComing($latlon);
            }
    
            $data = [
                "latlon" => $latlon,
                "res" => $res
            ];
        } else {
            $data = [
                "code" => 400,
                "error" => "You didnt search for anything"
            ];
        }

        return [$data];
    }
}
