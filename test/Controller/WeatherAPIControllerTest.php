<?php

namespace Linder\Controller;

use Anax\DI\DIMagic;
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
        $this->di = new DIMagic();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Swap out Config directory
        $this->di->get("configuration")->setBaseDirectories([ANAX_INSTALL_PATH . "/test/config/"]);

        // Use geocoder mock instead of opencage
        $this->di->setShared("geocoder", "\Linder\Mock\GeocoderMock");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherAPIController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the indexAction
     */
    public function testIndexAction()
    {
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
