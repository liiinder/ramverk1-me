<?php

namespace Linder\Model;

class IpVerifier
{
    private $di;
    private $api;

    /**
     * Constructor, allow for $di to be injected.
     *
     * @param \Anax\DI\DI a dependency/service container
     */
    public function __construct(\Anax\DI\DI $di)
    {
        $this->di = $di;
        $config = $this->di->get("configuration")->load("api.php");
        $this->api = $config["config"]["ipstack"];
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
        $url = $this->api["url"] . $ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url . $this->api["key"]);
        $data = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($data, true);
        $res["domain"] = filter_var($ip, FILTER_VALIDATE_IP) ? gethostbyaddr($ip) : null;
        $res["url"] = $url;

        return $res;
    }
}
