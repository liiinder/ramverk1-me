<?php

namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpVerifierControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
       // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup the controller
        $controller = new IpVerifierController();
        $controller->setDI($di);
        // $controller->initialize();

        $di->set("request", "\Anax\Request\Request");
        
        // test a false ip
        $di->get("request")->setGet("ip", "256.30.50.230");
        $res = $controller->indexAction();
        $this->assertEquals("ip: 256.30.50.230, valid: false, protocol: false, domain: false", $res);

        // test a valid IPv4 (dbwebb)
        $di->get("request")->setGet("ip", "194.47.150.9");
        $res = $controller->indexAction();
        $this->assertEquals("ip: 194.47.150.9, valid: true, protocol: IPv4, domain: dbwebb.se", $res);

        // test a valid IPv6 (dns google)
        $di->get("request")->setGet("ip", "2001:4860:4860::8888");
        $res = $controller->indexAction();
        $this->assertEquals("ip: 2001:4860:4860::8888, valid: true, protocol: IPv6, domain: dns.google", $res);

    }
}
