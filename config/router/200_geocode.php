<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geocoding",
            "mount" => "geocode",
            "handler" => "\Linder\Controller\GeocodeController",
        ]
    ]
];
