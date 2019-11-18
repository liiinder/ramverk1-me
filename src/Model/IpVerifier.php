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
    public function getJson($ip) : array
    {
        // $ip = $this->di->request->getGet("ip");
        $valid = filter_var($ip, FILTER_VALIDATE_IP) ? "true" : "false";
        if ($valid == "true") {
            $protocol = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "IPv4" : "IPv6";
            $getHost = gethostbyaddr($ip);
            $domain = ($getHost == $ip) ? "none" : $getHost;
        } else {
            $protocol = "false";
            $domain = "false";
        }
        return [
            "ip" => $ip,
            "valid" => $valid,
            "protocol" => $protocol,
            "domain" => $domain
        ];
    }

}
