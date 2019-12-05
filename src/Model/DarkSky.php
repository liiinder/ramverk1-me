<?php

namespace Linder\Model;

use Linder\Model\Curl;

/**
 * A model class retrievieng data from an external server.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class DarkSky
{
    private $config;
    private $curl;

    /**
     * Constructor, allow for $di to be injected.
     *
     * @param $config e container
     */
    public function __construct(Array $config)
    {
        $this->config = $config;
        $this->curl = new Curl();
    }

    /**
     * Set config
     */
    public function setConfig(Array $config)
    {
        $this->config = $config;
    }

    /**
     * Function that takes an coordinate and gets upcomming weather.
     *
     * @param string $latlon
     *
     * @return array $result
     */
    public function getWeatherComing(String $latlon) : array
    {
        $res = [];
        $res[0] = $this->curl->single($this->config["url"] . $latlon . $this->config["single"]);
        for ($i = 0; $i < count($res[0]["daily"]["data"]); $i++) {
            $time = $res[0]["daily"]["data"][$i]["time"];
            $res[0]["daily"]["data"][$i]["date"] = date("Y-m-d", $time);
        }
        return $res;
    }


    /**
     * Function that takes an coordinate and get past 30 days weather
     *
     * @param string $latlon
     *
     * @return array $result
     */
    public function getWeatherPast(String $latlon) : array
    {
        $curr = time();
        $urls = [];
        for ($i = 0; $i < 30; $i++) {
            // take away a day from current time
            $curr -= 86400;
            $urls[] = $this->config["url"] . $latlon . "," . $curr . $this->config["multi"];
        }
        $res = $this->curl->multi($urls);
        for ($i = 0; $i < count($res); $i++) {
            $time = $res[$i]["daily"]["data"][0]["time"];
            $res[$i]["daily"]["data"][0]["date"] = date("Y-m-d", $time);
        }
        return $res;
    }
}
