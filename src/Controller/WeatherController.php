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
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $search = $this->di->get("request")->getGet("search");
        $default = "57.708870,11.974560";
        
        if (filter_var($search, FILTER_VALIDATE_IP)) {
            $res = $this->di->get("ipverifier")->getJson($search);
            $res = ((!$res["latitude"]) || (!$res["longitude"])) ? "" : $res["latitude"] . "," . $res["longitude"];
        } else {
            $config = $this->di->get("configuration")->load("api.php");
            $geocoder = $this->di->get("geocoder");
            $coords = new Coordinates($geocoder);
            $res = $coords->getCoordinates($search ?? $default);
        }

        $error = ($res == "") ? 'Din sökning "' . $search . '" gav inget resultat, visar Göteborg istället.' : "";
        $latlon = ($res == "") ? $default : $res;

        $darksky = $this->di->get("darksky");
        $type = $this->di->get("request")->getGet("type");
        if ($type == "past") {
            $res = $darksky->getWeatherPast($latlon);
        } else {
            $res = $darksky->getWeatherComing($latlon);
        }

        $data = [
            "latlon" => $latlon,
            "res" => $res,
            "error" => $error
        ];

        $page->add("weather/main", $data);

        return $page->render([
            "title" => "Weather",
        ]);
    }
}
