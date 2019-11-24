<?php
namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpVerifierMock class.
 */
class IpVerifierMockControllerTest extends TestCase
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

        // Set the API to Mock
        $di->get("request")->setGet("test", "true");

        // Setup the controller
        $controller = new IpVerifierMockController();
        $controller->setDI($di);

        // test a valid IPv4 (dbwebb)
        $di->get("request")->setGet("ip", "194.47.150.9");
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals("194.47.150.9", $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals("ipv4", $res[0]["type"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertContains("dbwebb", $res[0]["domain"]);

        // testing a false ip
        $ip = "ThisNoIP";
        $di->get("request")->setGet("ip", $ip);
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals(null, $res[0]["type"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals(null, $res[0]["domain"]);

        // test a valid IPv6 (dns google)
        $ip = "2001:4860:4860::8888";
        $di->get("request")->setGet("ip", $ip);
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals("ipv6", $res[0]["type"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals("dns.google", $res[0]["domain"]);
    }
}
