<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "API Mock.",
            "mount" => "apimock",
            "handler" => "\Linder\Controller\APIMockController",
        ],
    ]
];
