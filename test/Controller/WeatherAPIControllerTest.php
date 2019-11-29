<?php

namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherAPIControllerTest extends TestCase
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
        $this->controller = new WeatherAPIController();
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

        // Test without a search
        $res = $this->controller->indexAction();
        $this->assertArrayHasKey("code", $res[0]);
        $this->assertArrayHasKey("error", $res[0]);

        // Searching on fail to trigger the Mock class error code.
        $this->di->get("request")->setGet("search", "fail");
        $res = $this->controller->indexAction();
        $this->assertArrayHasKey("code", $res[0]);
        $this->assertArrayHasKey("error", $res[0]);

        // Test an IP search
        $this->di->get("request")->setGet("search", "8.8.8.8");
        $res = $this->controller->indexAction();

        // Test request for a city and past weather
        $this->di->get("request")->setGet("type", "past");
        $this->di->get("request")->setGet("search", "Stockholm");
        $res = $this->controller->indexAction();

        // Test request for a city and comin weather
        $this->di->get("request")->setGet("type", "coming");
        $this->di->get("request")->setGet("search", "Stockholm");
        $res = $this->controller->indexAction();

        // Test the return type
        $this->assertIsArray($res);
    }
}
