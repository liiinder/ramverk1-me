<?php

namespace Linder\Mock;

class IpVerifierMock
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
    public function getJson($ip) : array
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
            "latitude" => 57.70887,
            "longitude" => 11.97456,
            "country_name" => null,
            "city" => null
        ];
    }
}
