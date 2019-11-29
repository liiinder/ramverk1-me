<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Linder\Model\IpVerifier;

/**
 * A controller that handles a get request
 * uses a model and returns a Json.
 */
class APIMockController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : array
    {
        $ip = $this->di->request->getGet("ip") ?: $this->di->request->getServer("REMOTE_ADDR");
        return [
            $this->di->get("ipverifier")->oldGetJson($ip)
        ];
    }

    public function darkSkyMockAction() : Array
    {
        $darksky = new \Linder\Mock\DarkSkyMock();
        $url = $this->di->request->getCurrentUrl();
        $res = (strpos($url, "?exclude=currently,flags") || $this->di->request->getGet("type") == "past") ?
            $darksky->getWeatherPast("") :
            $darksky->getWeatherComing("");
        return $res;
    }
}
