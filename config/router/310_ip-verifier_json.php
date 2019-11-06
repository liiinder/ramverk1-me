<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip Verifier to json.",
            "mount" => "iptojson",
            "handler" => "\Linder\Controller\IpVerifierToJsonController",
        ],
    ]
];
