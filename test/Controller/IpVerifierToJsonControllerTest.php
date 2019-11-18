<?php
namespace Linder\Controller;
use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test the IpVerifierToJson class.
 */
class IpVerifierToJsonControllerTest extends TestCase
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
        $controller = new IpVerifierToJsonController();
        $controller->setDI($di);

        // test a valid IPv4 (dbwebb)
        $di->get("request")->setGet("ip", "194.47.150.9");
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals("194.47.150.9", $res[0]["ip"]);
        $this->assertArrayHasKey("valid", $res[0]);
        $this->assertEquals("true", $res[0]["valid"]);
        $this->assertArrayHasKey("protocol", $res[0]);
        $this->assertEquals("IPv4", $res[0]["protocol"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals("dbwebb.tekproj.bth.se", $res[0]["domain"]);

        // testing a false ip
        $ip = "This is not a valid ip";
        $di->get("request")->setGet("ip", $ip);
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertArrayHasKey("valid", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertEquals("false", $res[0]["valid"]);
        $this->assertArrayHasKey("protocol", $res[0]);
        $this->assertEquals("false", $res[0]["protocol"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals("false", $res[0]["domain"]);

        // test a valid IPv6 (dns google)
        $ip = "2001:4860:4860::8888";
        $di->get("request")->setGet("ip", $ip);
        $res = $controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertArrayHasKey("valid", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertEquals("true", $res[0]["valid"]);
        $this->assertArrayHasKey("protocol", $res[0]);
        $this->assertEquals("IPv6", $res[0]["protocol"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals("dns.google", $res[0]["domain"]);
    }
}