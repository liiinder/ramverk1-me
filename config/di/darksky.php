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
                $obj = new \Linder\Model\DarkSky($this);
                return $obj;
            }
        ],
    ],
];
