<?php

// namespace Linder\Controller;

// use Anax\DI\DIFactoryConfig;
// use PHPUnit\Framework\TestCase;

// /**
//  * Test the SampleController.
//  */
// class IpVerifierControllerTest extends TestCase
// {

//     // Create the di container.
//     protected $di;
//     protected $controller;

//     /**
//      * Prepare before each test.
//      */
//     protected function setUp()
//     {
//         global $di;

//         // Setup di
//         $this->di = new DIFactoryConfig();
//         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

//         // Use a different cache dir for unit test
//         $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

//         // View helpers uses the global $di so it needs its value
//         $di = $this->di;

//         // Setup the controller
//         $this->controller = new IpVerifierController();
//         $this->controller->setDI($this->di);
//     }

//     /**
//      * Test the indexAction
//      */
//     public function testIndexAction()
//     {
//         $this->di->get("request")->setGet("ip", "194.47.150.9");
//         $res = $this->controller->indexAction();
//         $this->assertIsObject($res);
//         $this->assertInstanceOf("Anax\Response\Response", $res);
//         $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

//         // Check that the body contains some known words
//         $body = $res->getBody();
//         $this->assertContains("Verifiera en IP-address.", $body);
//         $this->assertContains("ip: 194.47.150.9,", $body);
//     }

//     /**
//      * Test the validateActionGet function
//      */
//     public function testValidateActionGet()
//     {
//         // test a false ip
//         $this->di->get("request")->setGet("ip", "256.30.50.230");
//         $res = $this->controller->validateActionGet();
//         $this->assertEquals("ip: 256.30.50.230, valid: false, protocol: false, domain: false", $res);

//         // test a valid IPv4 (dbwebb)
//         $this->di->get("request")->setGet("ip", "194.47.150.9");
//         $res = $this->controller->validateActionGet();
//         $this->assertEquals("ip: 194.47.150.9, valid: true, protocol: IPv4, domain: dbwebb.se", $res);

//         // test a valid IPv6 (dns google)
//         $this->di->get("request")->setGet("ip", "2001:4860:4860::8888");
//         $res = $this->controller->validateActionGet();
//         $this->assertEquals("ip: 2001:4860:4860::8888, valid: true, protocol: IPv6, domain: dns.google", $res);
//     }
// }
