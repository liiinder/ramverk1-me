<?php

namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherControllerTest extends TestCase
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

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
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

        // Test an IP search
        $this->di->get("request")->setGet("search", "8.8.8.8");
        $this->di->get("request")->setGet("type", "past");
        $res = $this->controller->indexAction();
        $body = $res->getBody();
        $this->assertContains('Molnigt under dagen.', $body);

        // Test a city and coming weather
        $this->di->get("request")->setGet("type", "coming");
        $this->di->get("request")->setGet("search", "Stockholm");
        $res = $this->controller->indexAction();
        
        // Check that the body contains some known words
        // Doesnt really matter as we dont use the real API
        $body = $res->getBody();
        // checking so it got the summary from the mock api
        $this->assertContains('Duggregn under dagen.', $body);
        
        // Test the return type
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
}
