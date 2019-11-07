<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller that handles a get request
 * and returns if its a valid ip or not.
 */
class IpVerifierController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Ipverifier";
        $page = $this->di->get("page");

        $ip = $this->di->request->getGet("ip");
        $res = $this->validateActionGet();

        $data = [
            "ip" => $ip,
            "res" => $res
        ];

        $page->add("ipverifier/main", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function validateActionGet() : string
    {
        $ip = $this->di->request->getGet("ip");
        $valid = filter_var($ip, FILTER_VALIDATE_IP) ? "true" : "false";
        if ($valid == "true") {
            $protocol = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "IPv4" : "IPv6";
            $getHost = gethostbyaddr($ip);
            $domain = ($getHost == $ip) ? "none" : $getHost;
        } else {
            $protocol = "false";
            $domain = "false";
        }
        return "ip: ".$ip.", valid: ".$valid.", protocol: ".$protocol.", domain: ".$domain;
    }
}
