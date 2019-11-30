<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "geocoder" => [
            "shared" => true,
            "callback" => function () {
                $cfg = $this->get("configuration");
                $config = $cfg->load("api.php");
                $obj = new \OpenCage\Geocoder\Geocoder($config["config"]["opencage"]);
                return $obj;
            }
        ],
    ],
];
