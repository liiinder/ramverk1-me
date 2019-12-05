<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "darksky" => [
            "shared" => true,
            "callback" => function () {
                $cfg = $this->get("configuration");
                $config = $cfg->load("api.php");
                $obj = new \Linder\Model\DarkSky($config["config"]["darksky"]);
                return $obj;
            }
        ],
    ],
];
