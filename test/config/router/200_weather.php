<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather api",
            "mount" => "weatherapi",
            "handler" => "\Linder\Controller\WeatherAPIController",
        ],
        [
            "info" => "Weather info",
            "mount" => "weather",
            "handler" => "\Linder\Controller\WeatherController",
        ]
    ]
];
