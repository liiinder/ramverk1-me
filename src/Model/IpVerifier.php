<?php

namespace Linder\Model;

class IpVerifier
{
    /**
     * This method takes one argument:
     * A string that we are going to check if its a valid ip-adress.
     * Returning an json with some information.
     *
     * @param string $value
     *
     * @return array
     */
    public function oldGetJson($ip) : array
    {
        $valid = filter_var($ip, FILTER_VALIDATE_IP) ? "true" : "false";
        if ($valid == "true") {
            $protocol = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "ipv4" : "ipv6";
            $getHost = gethostbyaddr($ip);
            $domain = ($getHost == $ip) ? null : $getHost;
        } else {
            $protocol = null;
            $domain = null;
        }
        return [
            "ip" => $ip,
            "type" => $protocol,
            "domain" => $domain,
            "latitude" => null,
            "longitude" => null,
            "country_name" => null,
            "city" => null
        ];
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
        global $di;

        $config = $di->get("configuration")->load("ipstack");
        $ipstack = ($di->get("request")->getGet("test")) ? $config["config"]["test"] : $config["config"]["ipstack"];
        $url = $ipstack["url"] . $ip . $ipstack["key"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($data, true);
        $res["domain"] = filter_var($ip, FILTER_VALIDATE_IP) ? gethostbyaddr($ip) : null;
        $res["url"] = $url;

        return $res;
    }
}
