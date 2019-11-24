<?php

namespace Linder\Model;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;

/**
 * Test the IpVerifierToJson class.
 */
class IpVerifierModelTest extends TestCase
{
    protected $di;

        /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;
    }

    /**
     * Test the route "index".
     */
    public function testIpVerifier()
    {
        // Setup the verifier class
        $ipverifier = new IpVerifier();
        
        // Set $_GET to test so the model are running the mock API
        $this->di->get("request")->setGet("test", "true");

        // test a valid IPv4 (dbwebb)
        $res = $ipverifier->getJson("194.47.150.9");
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertEquals("194.47.150.9", $res["ip"]);
        $this->assertArrayHasKey("type", $res);
        $this->assertEquals("ipv4", $res["type"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertContains("dbwebb", $res["domain"]);

        // testing a false ip
        $ip = "ThisNoIP";
        $res = $ipverifier->getJson($ip);
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertEquals($ip, $res["ip"]);
        $this->assertArrayHasKey("type", $res);
        $this->assertEquals(null, $res["type"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertEquals(null, $res["domain"]);

        // test a valid IPv6 (dns google)
        $ip = "2001:4860:4860::8888";
        $res = $ipverifier->getJson($ip);
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertEquals($ip, $res["ip"]);
        $this->assertArrayHasKey("type", $res);
        $this->assertEquals("ipv6", $res["type"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertEquals("dns.google", $res["domain"]);
        $this->assertEquals("http://localhost:8080/ramverk1/me/redovisa/htdocs/ipmock?ip=2001:4860:4860::8888", $res["url"]);
    }
}
