<?php

namespace Linder\Model;

use PHPUnit\Framework\TestCase;

/**
 * Test the IpVerifierToJson class.
 */
class IpVerifierTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIpVerifier()
    {
        // Setup the verifier class
        $ipverifier = new IpVerifier();

        // test a valid IPv4 (dbwebb)
        $res = $ipverifier->getJson("194.47.150.9");
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertEquals("194.47.150.9", $res["ip"]);
        $this->assertArrayHasKey("valid", $res);
        $this->assertEquals("true", $res["valid"]);
        $this->assertArrayHasKey("protocol", $res);
        $this->assertEquals("IPv4", $res["protocol"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertEquals("dbwebb.tekproj.bth.se", $res["domain"]);

        // testing a false ip
        $ip = "This is not a valid ip";
        $res = $ipverifier->getJson($ip);
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertArrayHasKey("valid", $res);
        $this->assertEquals($ip, $res["ip"]);
        $this->assertEquals("false", $res["valid"]);
        $this->assertArrayHasKey("protocol", $res);
        $this->assertEquals("false", $res["protocol"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertEquals("false", $res["domain"]);

        // test a valid IPv6 (dns google)
        $ip = "2001:4860:4860::8888";
        $res = $ipverifier->getJson($ip);
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res);
        $this->assertArrayHasKey("valid", $res);
        $this->assertEquals($ip, $res["ip"]);
        $this->assertEquals("true", $res["valid"]);
        $this->assertArrayHasKey("protocol", $res);
        $this->assertEquals("IPv6", $res["protocol"]);
        $this->assertArrayHasKey("domain", $res);
        $this->assertEquals("dns.google", $res["domain"]);
    }
}
