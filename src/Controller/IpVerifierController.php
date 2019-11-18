<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Linder\Model\IpVerifier;

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
        $page = $this->di->get("page");

        $ip = $this->di->request->getGet("ip") ?: $this->di->request->getServer("REMOTE_ADDR");

        // $res = IpVerifier::getJson($ip);
        $ipverifier = new \Linder\Model\IpVerifier;
        $res = $ipverifier->getJson($ip);

        $data = [
            "ip" => $ip,
            "domain" => $res["domain"],
            "protocol" => $res["protocol"],
            "valid" => $res["valid"]
        ];

        $page->add("ipverifier/main", $data);
        // $page->add("ipverifier/debug", $data);

        return $page->render([
            "title" => "Ipverifier",
        ]);
    }

}
