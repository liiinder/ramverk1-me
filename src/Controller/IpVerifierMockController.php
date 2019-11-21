<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Linder\Model\IpVerifier;

/**
 * A controller that handles a get request
 * uses a model and returns a Json.
 */
class IpVerifierMockController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : array
    {
        $ip = $this->di->request->getGet("ip") ?: $this->di->request->getServer("REMOTE_ADDR");
        $ipverifier = new IpVerifier();
        return [
            $ipverifier->oldGetJson($ip)
        ];
    }
}