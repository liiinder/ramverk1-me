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

        // Use geocoder mock instead of opencage
        $this->di->setShared("geocoder", "\Linder\Mock\GeocoderMock");

        // Set config to use mock servers
        $ipstack = [
            "key" => "",
            "url" => "http://localhost:8080/ramverk1/me/redovisa/htdocs/apimock?ip="
        ];
        $darksky = [
            "url" => "http://localhost:8080/ramverk1/me/redovisa/htdocs/apimock/darkskymock?",
            "single" => "",
            "multi" => "?exclude=currently,flags"
        ];
        $this->di->get("ipverifier")->setConfig($ipstack);
        $this->di->get("darksky")->setConfig($darksky);

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the indexAction
     */
    public function testIndexAction()
    {
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
