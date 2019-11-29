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
            $ipverifier = new \Linder\Model\IpVerifier();
            $res = $ipverifier->getJson($search);
            $latlon = ((!$res["latitude"]) || (!$res["longitude"])) ? "" : $res["latitude"] . "," . $res["longitude"];
        } else if ($search) {
            $this->di->get("configuration")->load("api.php");
            $geocoder = $this->di->get("session")->has("test") ? new \Linder\Mock\GeocoderMock() : new \OpenCage\Geocoder\Geocoder($config["config"]["opencage"]);
            $coords = new Coordinates($geocoder);
            $latlon = $coords->getCoordinates($search);
        }
        if (($search) && ($latlon != "")) {
            $darksky = new \Linder\Model\DarkSky($this->di);
            $type = $this->di->get("request")->getGet("type");
            if ($type == "past") {
                $res = $darksky->getWeatherPast($latlon);
                for ($i = 0; $i < count($res); $i++) {
                    $time = $res[$i]["daily"]["data"][0]["time"];
                    $res[$i]["daily"]["data"][0]["date"] = date("Y-m-d", $time);
                }
            } else {
                $res = [];
                $res[0] = $darksky->getWeatherComing($latlon);
                for ($i = 0; $i < count($res[0]["daily"]["data"]); $i++) {
                    $time = $res[0]["daily"]["data"][$i]["time"];
                    $res[0]["daily"]["data"][$i]["date"] = date("Y-m-d", $time);
                }
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
