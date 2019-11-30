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
                $obj = new \Linder\Model\IpVerifier($this);
                return $obj;
            }
        ],
    ],
];
