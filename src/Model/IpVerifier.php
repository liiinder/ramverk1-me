<?php

namespace Linder\Model;

use Linder\Model\Curl;

class IpVerifier
{
    private $curl;
    private $config;

    /**
     * Constructor, allow for $di to be injected.
     *
     * @param Array $config a config file containing keys url / key
     */
    public function __construct($config)
    {
        $this->curl = new Curl();
        $this->config = $config;
    }

    /**
     * Set config
     */
    public function setConfig(Array $config)
    {
        $this->config = $config;
    }

    /**
     * This method takes one argument:
     * A string that we are going to check if its a valid ip-adress.
     * Returning an json with some information.
     *
     * @param string $value
     *
     * @return array
     */
    public function getJson($ip) : array
    {
        $url = $this->config["url"] . $ip;
        $res = $this->curl->single($url . $this->config["key"]);
        $res["domain"] = filter_var($ip, FILTER_VALIDATE_IP) ? gethostbyaddr($ip) : null;
        $res["url"] = $url;

        return $res;
    }
}
