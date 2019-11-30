<?php
/**
 * Config-file for different api_keys.
 */
return [
    // Ipstack
    // Its concatenated in this order -> url . ip . key
    "ipstack" => [
        "key" => "",
        "url" => "http://localhost:8080/ramverk1/me/redovisa/htdocs/apimock?ip="
    ],
    // Darksky using it like htis -> url . lat , lon
    "darksky" => "http://localhost:8080/ramverk1/me/redovisa/htdocs/apimock/darkskymock?",
];
