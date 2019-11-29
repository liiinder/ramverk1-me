<?php

namespace Linder\Model;

/**
 * A model class retrievieng data from an external server.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class DarkSky
{
    private $di;
    private $config;
    private $url;

    /**
     * Constructor, allow for $di to be injected.
     *
     * @param \Anax\DI\DIFactoryConfig a dependency/service container
     */
    public function __construct(\Anax\DI\DIFactoryConfig $di)
    {
        $this->di = $di;
        $this->config = $this->di->get("configuration")->load("api.php");
        $this->url = $this->di->get("session")->has("test") ? $this->config["config"]["darkskytest"] : $this->config["config"]["darksky"];
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

        // Setup options
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $this->url . $latlon . "?lang=sv&units=si"
        ];
        //  Initiate curl handler
        $ch = curl_init();
        // Set options
        curl_setopt_array($ch, $options);
        // Execute
        $data = curl_exec($ch);
        // Closing
        curl_close($ch);
        $res = json_decode($data, true);

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
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            // take away a day from current time
            $curr -= 86400;
            $dates[] = $curr;
        }
        // Setup options
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
        ];
        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        foreach ($dates as $date) {
            $ch = curl_init("$this->url$latlon,$date?exclude=currently,flags&lang=sv&units=si");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }
        return $response;
    }
}
