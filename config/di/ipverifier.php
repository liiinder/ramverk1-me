<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "ipverifier" => [
            "shared" => true,
            "callback" => function () {
                $cfg = $this->get("configuration");
                $config = $cfg->load("api.php");
                $obj = new \Linder\Model\IpVerifier($config["config"]["ipstack"]);
                return $obj;
            }
        ],
    ],
];
