<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip Verifier.",
            "mount" => "ipverifier",
            "handler" => "\Linder\Controller\IpVerifierController",
        ],
        [
            "info" => "Ip Verifier to json.",
            "mount" => "ipapi",
            "handler" => "\Linder\Controller\IpVerifierAPIController",
        ]
    ]
];
