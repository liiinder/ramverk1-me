<?php

namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpVerifierControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Mock ipverifier
        $this->di->setShared("ipverifier", "\Linder\Mock\IpVerifierMock");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new IpVerifierController();
        $this->controller->setDI($this->di);
    }

    /**
     * Removing the session test after testing is done.
     */
    protected function tearDown()
    {
        $this->di->get("session")->delete("test");
    }

    /**
     * Test the indexAction
     */
    public function testIndexAction()
    {
        // Set the API to Mock
        $this->di->get("session")->set("test", "true");

        // Test default IP
        $this->di->get("request")->setServer("REMOTE_ADDR", "8.8.8.8");
        $res = $this->controller->indexAction();

        // Check that the body contains some known words
        $body = $res->getBody();
        $this->assertContains('<input type="text" name="ip" value="8.8.8.8">', $body);
        $this->assertContains("Verifiera en IP-address.", $body);
        
        // test IP with GET
        $this->di->get("request")->setGet("ip", "194.47.150.9");
        $res = $this->controller->indexAction();
        
        // Check that the body contains some known words
        $body = $res->getBody();
        $this->assertContains("Verifiera en IP-address.", $body);
        $this->assertContains('<input type="text" name="ip" value="194.47.150.9">', $body);

        // Test the return type
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
}
